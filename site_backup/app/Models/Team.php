<?php

namespace App\Models;

use App\Models\Traits\HasUploadableAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;

class Team extends Model
{
    use HasUploadableAttributes;

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    protected $uploadables = [
        'avatar',
        'banner',
    ];

    protected $guarded = [];
    
    public function members()
    {
        return $this->belongsToMany(User::class, 'team_member')->withPivot('role')->withTimestamps();
    }
    
    public function managers()
    {
        return $this->members()->wherePivot('role', 'MANAGER');
    }
    
    public function candidates()
    {
        return $this->belongsToMany(User::class, 'team_candidate')->withTimestamps();
    }
    
    public function invites()
    {
        return $this->belongsToMany(User::class, 'team_invites')->withTimestamps();
    }
    
    public function bans()
    {
        return $this->belongsToMany(User::class, 'team_banished')->withTimestamps();
    }
    
    public function networks()
    {
        return $this->belongsToMany(Network::class)->withPivot('identifier')->withTimestamps();
    }
    
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    
    public function getAvatarAttribute()
    {
        return $this->getUploadableAttribute('avatar');
    }
    
    public function setAvatarAttribute(UploadedFile $file)
    {
        $img = Image::make($file);
        $img->fit(170, 170);
        $this->setUploadableAttribute('avatar', $img);
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
    
    protected function getDefaultStoragePath($field)
    {
        if ($field == 'avatar') {
            return storage_path(config("uploads.storage_path") . DIRECTORY_SEPARATOR . $this->getFilepathForField($field, 'default_' . ($this->id % 5)));
        }
        return storage_path(config("uploads.storage_path") . DIRECTORY_SEPARATOR . $this->getFilepathForField($field, 'default'));
    }
    
    public function hasMaxMembersCount()
    {
        return $this->members->count() >= $this->game->max_players_per_team;
    }
    
    public function getRank()
    {
        return $this->game->teams()->where('score', '>', $this->score)->count() + 1;
    }
    
    public function addScore(Match $match, bool $win)
    {
        $score = $this->getEloAverage();
        HistosScores::create([
            'team_id' => $this->id,
            'game_id' => $match->game->id,
            'score' => $score,
            'diff' => $score - $this->score,
            'match_id' => $match->id,
        ]);
        $this->update([
            'score' => $score,
            'win' => $win ? DB::raw('win + 1') : DB::raw('win'),
            'lost' => !$win ? DB::raw('lost + 1') : DB::raw('lost'),
        ]);
    }
    
    public function getEloAverage()
    {
        return (int)round(
            DB::table('game_infos')
              ->join('team_member', 'team_member.user_id', 'game_infos.user_id')
              ->where('team_member.team_id', $this->id)
              ->avg(DB::raw('game_infos.score'))
        );
    }
    
    public function recalculateScore()
    {
        $this->update(['score' => $this->getEloAverage()]);
    }
}
