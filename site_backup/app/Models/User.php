<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use App\Models\Traits\HasUploadableAttributes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes, Filterable, HasUploadableAttributes, Billable;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'email_confirmed',
        'birthdate',
    ];

    protected $fillable = [
        'username', 
        'email',
        'password',
        'locale',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $uploadables = [
        'avatar',
        'banner',
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function networks()
    {
        return $this->belongsToMany(Network::class)->withPivot('identifier')->withTimestamps();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ownteams()
    {
        return $this->hasMany(Team::class, 'owner_id');
    }
    
    /**
     * @param \App\Models\Game $game
     *
     * @return Builder
     */
    public function ownteamsByGame(Game $game)
    {
        return $this->ownteams()->whereHas('game', function(Builder $query) use ($game) {
            return $query->where('id', $game->id);
        });
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_member')->withPivot('role')->withTimestamps();
    }
    
    public function activeTeam()
    {
        return $this->belongsTo(Team::class);
    }
    
    /**
     * @param \App\Models\Game $game
     *
     * @return Builder
     */
    public function teamsByGame(Game $game)
    {
        return $this->teams()->whereHas('game', function(Builder $query) use ($game) {
            return $query->where('id', $game->id);
        });
    }
    
    public function candidatures()
    {
        return $this->belongsToMany(Team::class, 'team_candidate')->withTimestamps();
    }
    
    public function invites()
    {
        return $this->belongsToMany(Team::class, 'team_invites')->withTimestamps();
    }
    
    public function bans()
    {
        return $this->belongsToMany(Team::class, 'team_banished')->withTimestamps();
    }
    
    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_infos')->withTimestamps()->withPivot(['score', 'win', 'lost']);
    }
    
    public function squads()
    {
        return $this->belongsToMany(Squad::class, 'squads_members')->withPivot(['confirmed']);
    }
    
    public function matches(Game $game)
    {
        return DB::table('users')
                 ->distinct()
                 ->select('matches.*')
                 ->join('squads_members', 'user_id', '=', 'users.id')
                 ->join('matches', function (\Illuminate\Database\Query\JoinClause $join) {
                    $join->on('matches.squad1_id', '=', 'squads_members.squad_id')
                         ->orOn('matches.squad2_id', '=', 'squads_members.squad_id');
                 })
                 ->where('users.id', $this->id)
                 ->where('matches.game_id', $game->id);
    }
    
    public function matchesFinished(Game $game)
    {
        return $this->matches($game)
                    ->where('status', 'FINISH');
    }
    
    /**
     * A user may have multiple roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            config('laravel-permission.models.role'),
            config('laravel-permission.table_names.user_has_roles')
        )->withTimestamps();
    }

    /**
     * A user may have multiple direct permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(
            config('laravel-permission.models.permission'),
            config('laravel-permission.table_names.user_has_permissions')
        )->withTimestamps();
    }
    
    /**
     * Scope a query to filter staff users.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeStaff($query, $isStaff)
    {
        return $query->whereHas('roles', function (Builder $query) use ($isStaff) {
            $query->where('is_staff', $isStaff);
        });
    }
    
    public function canJudgeMatch()
    {
        return $this->hasAnyRole(['superadmin', 'admin', 'referee']);
    }
    
    public function canSeeChat(Match $match)
    {
        return $this->canJudgeMatch() || $match->concernedUsers()->get()->contains(function($item) {
            return $this->id == $item->id;
        });
    }
    
    public function isSuperAdmin()
    {
        return $this->hasRole('superadmin');
    }
    
    public function isPremium()
    {
        return $this->subscribed('premium');
    }
    
    public function getRank(Game $game)
    {
        $score = $this->getScore($game);
        return $game->users()->wherePivot('score', '>', $score)->count() + 1;
    }
    
    public function getScore(Game $game)
    {
        return $this->getScores($game)->score;
    }
    
    public function addScore(Match $match, int $score, bool $win)
    {
        HistosScores::create([
            'user_id' => $this->id,
            'game_id' => $match->game->id,
            'score' => $score,
            'diff' => $score - $this->getScore($match->game),
            'match_id' => $match->id,
        ]);
        $this->games()->updateExistingPivot($match->game->id, [
            'score' => $score,
            'win' => $win ? DB::raw('win + 1') : DB::raw('win'),
            'lost' => !$win ? DB::raw('lost + 1') : DB::raw('lost'),
        ]);
    }
    
    public function getScores(Game $game)
    {
        $gameSelected = $this->games()->find($game->id);
        if ($gameSelected) {
            return $gameSelected->pivot;
        } else {
            $this->initGameInfos($game);
            return $this->getScores($game);
        }
    }
    
    public function getAvatarAttribute()
    {
        return $this->getUploadableAttribute('avatar');
    }
    
    public function setAvatarAttribute(?UploadedFile $file)
    {
        if ($file === null) {
            $this->setUploadableAttribute('avatar', null);
        } else {
            $img = Image::make($file);
            $img->fit(170, 170);
            $this->setUploadableAttribute('avatar', $img);
        }
    }
    
    public function getBannerAttribute()
    {
        return $this->getUploadableAttribute('banner');
    }
    
    public function setBannerAttribute(UploadedFile $file)
    {
        $img = Image::make($file);
        $this->setUploadableAttribute('banner', $img);
    }
    
    public function addCredits(?Match $match, int $value)
    {
        $this->credits += $value;
        $this->save();
        
        HistosCredits::create([
            'user_id' => $this->id,
            'credits' => $this->credits,
            'diff' => $value,
            'match_id' => $match ? $match->id : null,
        ]);
    }
    
    public function removeCredits(?Match $match, int $value)
    {
        $this->addCredits($match, -$value);
    }
    
    protected function getDefaultStoragePath($field)
    {
        if ($field == 'avatar') {
            return storage_path(config("uploads.storage_path") . DIRECTORY_SEPARATOR . $this->getFilepathForField($field, 'default_' . ($this->id % 5)));
        }
        return storage_path(config("uploads.storage_path") . DIRECTORY_SEPARATOR . $this->getFilepathForField($field, 'default'));
    }
    
    public function initGameInfos(Game $game)
    {
        $this->games()->attach([$game->id => ['score' => config('app.default-elo')]]);
    }
    
    public function calculateAndSaveNewElo(Match $match, int $otherElo, bool $win)
    {
        $currentPlayerElo = $this->getScore($match->game);
        
        $D = $currentPlayerElo - $otherElo;
        if ($D > 400) {
            $D = 400;
        } elseif ($D < -400) {
            $D = -400;
        }
        
        $pD = 1 / (1 + pow(10, -$D / 400));
        
        if ($currentPlayerElo >= 2400) {
            $K = 15;
        } else {
            $nbMatchs = $this->matchesFinished($match->game)->count();
            if ($nbMatchs < 20) {
                $K = 60;
            } else {
                $K = 30;
            }
        }
        
        $W = ($win ? 1 : 0);
        
        $newElo = $currentPlayerElo + $K * ($W - $pD);
        
        $this->addScore($match, $newElo, $win);
    }
    
    public function getCurrentMatch(): ?Match
    {
        $squadWithMatch = $this->squads()->whereHas('match', function (Builder $query) {
            $query->where('status', 'WAIT_JOIN')
                  ->orWhere('status', 'WAIT_CONFIRM')
                  ->orWhere('status', 'IN_PROGRESS');
        })->first();
        
        if ($squadWithMatch) {
            return $squadWithMatch->match;
        }
        return null;
    }
}
