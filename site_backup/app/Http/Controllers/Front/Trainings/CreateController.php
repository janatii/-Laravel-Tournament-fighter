<?php

namespace App\Http\Controllers\Front\Trainings;

use App\Models\Game;
use App\Models\Gamemode;
use App\Models\Match;
use App\Models\Round;
use App\Models\Squad;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        
        $game = $this->checkAndReturnGameSelected($request);
        
        $this->validate($request, [
            'team' => [
                'required',
                Rule::exists('team_member', 'team_id')->where(function (Builder $query) use ($user) {
                    $query->where('user_id', $user->id);
                }),
            ],
            'rule' => "required|in:FRIENDLY,RANKED,WAGER",
            'mode' => [
                'present',
                'nullable',
                Rule::exists('gamemodes', 'id')->where('game_id', $game->id),
            ],
            'bestof' => "required|in:{$game->bo_list}",
            'nbplayers' => "required|in:{$game->vs_list}",
            'maps' => "required_if:rule,FRIENDLY|array",
            'maps.*' => [
                "required_if:rule,FRIENDLY",
                Rule::exists('maps', 'id')->where('game_id', $game->id),
            ],
            'manager' => [
                'required',
                Rule::exists('team_member', 'user_id')->where(function (Builder $query) use ($request) {
                    $query->where('team_id', $request->input('team'))
                          ->where('role', 'MANAGER');
                }),
            ],
            'players' => 'required|array',
            'players.*' => [
                Rule::exists('team_member', 'user_id')->where('team_id', $request->input('team')),
            ],
            'bet' => 'required_if:rule,WAGER|bet',
        ]);
        
        $team = Team::find($request->input('team'));
        $rule = $request->input('rule');
        $modeId = $request->input('mode');
        $bo = $request->input('bestof');
        $nbplayers = $request->input('nbplayers');
        $mapsIds = $request->input('maps', []);
        $managerId = $request->input('manager');
        $playersIds = $request->input('players');
        $manager = User::find($managerId);
        $players = User::findMany($playersIds);
        $bet = $request->input('bet');
        
        $users = $players->add($manager)->unique('id');
        
        try {
            $this->checkCurrentUserInUsers($users);
            
            $gamemodes = $this->getSelectedGamemodesSequence($modeId, $bo, $game);
        
            if ($rule === 'FRIENDLY') {
                $this->checkMapsSelectedExistInGame($request, $game, $bo);
            }
            
            if ($rule === 'FRIENDLY') {
                $this->checkMapsGamemodes($game, $bo, $gamemodes, $mapsIds);
            } else {
                $mapsIds = $this->getRandomMapsIds($gamemodes);
            }
            
            if ($rule === 'WAGER') {
                $this->checkPlayersCredits($bet, $players);
            }
            
            $this->checkUsersActiveTeam($users, $team);
            
            $this->checkUsersGameNetworkSet($users, $game);
            
            $this->checkUsersNotAlreadyInGame($users);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
        
        DB::beginTransaction();
        
        // Match Creation
        $match = new Match();
        $match->premium = $user->isPremium();
        $match->wait_referee = false;
        $match->type = $rule;
        $match->bo = $bo;
        $match->vs = $nbplayers;
        $match->status = 'WAIT_JOIN';
        $match->creator()->associate($user->id);
        $match->game()->associate($game);
        if ($modeId) {
            $match->fullGamemode()->associate($modeId);
        }
        if ($rule === 'WAGER') {
            $match->bet = $bet;
        }
        $match->filter_score_min = 0;
        $match->filter_score_max = 5000;
        $match->save();
        
        // Squad Creation
        $squad = new Squad();
        $squad->manager()->associate($managerId);
        $squad->team()->associate($team);
        $squad->match()->associate($match);
        $squad->save();
        
        $this->attachSquadMembers($rule, $nbplayers, $playersIds, $squad);
    
        // Associate squad with match
        $match->squad1()->associate($squad);
        $match->save();
        
        // Rounds Creation
        for ($i = 0; $i < $bo; $i++) {
            $round = new Round();
            $round->match()->associate($match);
            $round->map()->associate($mapsIds[$i]);
            $round->gamemode()->associate($gamemodes[$i]);
            $round->save();
        }
        
        DB::commit();
        
        event(new \App\Events\MatchCreated($match));
        
        return response()->json(['message' => 'Match created !']);
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function join(Request $request)
    {
        $user = Auth::user();
        
        $game = $this->checkAndReturnGameSelected($request);
    
        $this->validate($request, [
            'team' => [
                'required',
                Rule::exists('team_member', 'team_id')->where('user_id', $user->id),
            ],
            'match' => [
                'required',
                Rule::exists('matches', 'id')->where('status', 'WAIT_JOIN'),
            ],
            'manager' => [
                'required',
                Rule::exists('team_member', 'user_id')->where(function (Builder $query) use ($request) {
                    $query->where('team_id', $request->input('team'))
                          ->where('role', 'MANAGER');
                }),
            ],
            'players' => 'required|array',
            'players.*' => [
                Rule::exists('team_member', 'user_id')->where('team_id', $request->input('team')),
            ],
        ]);
        
        $team = Team::find($request->input('team'));
        $match = Match::find($request->input('match'));
        $managerId = $request->input('manager');
        $playersIds = $request->input('players');
        $manager = User::find($managerId);
        $players = User::findMany($playersIds);
        
        $users = $players->add($manager)->unique('id');
        
        try {
            $this->checkCurrentUserInUsers($users);
            
            if ($match->type == 'WAGER') {
                $this->checkPlayersCredits($match->bet, $players);
            }
            
            $this->checkUsersActiveTeam($users, $team);
            
            $this->checkUsersGameNetworkSet($users, $game);
            
            $this->checkUsersNotAlreadyInGame($users);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    
        DB::beginTransaction();
        
        // Squad Creation
        $squad = new Squad();
        $squad->manager()->associate($managerId);
        $squad->team()->associate($team);
        $squad->match()->associate($match);
        $squad->save();
        
        $this->attachSquadMembers($match->type, $match->vs, $playersIds, $squad);
    
        $nextState = 'IN_PROGRESS';
        if ($match->type == 'WAGER') {
            $nextState = 'WAIT_CONFIRM';
        }
        
        $rowsAffected = DB::table('matches')
                            ->where('id', $match->id)
                            ->where('status', 'WAIT_JOIN')
                            ->update(['status' => $nextState, 'squad2_id' => $squad->id]);
        if ($rowsAffected == 0) {
            DB::rollBack();
            
            return response()->json(['message' => trans('app.front.trainings.list.modals.errors.already-in-progress')], 403);
        }
        
        DB::commit();
        
        event(new \App\Events\MatchJoined($match));
        
        if ($match->type != 'WAGER') {
            $match->launch();
        }
        
        event(new \App\Events\MatchRedirect($match));
        
        return response()->json(['message' => 'Match joined !']);
    }
    
    protected function getRandomMapsIds(Collection $gamemodes): array
    {
        return $gamemodes->map(function(Gamemode $gamemode) {
            return $gamemode->maps->random(1)->first()->id;
        })->toArray();
    }
    
    /**
     * @param int $modeId
     * @param int $bo
     * @param Game $game
     *
     * @return Collection
     */
    private function getSelectedGamemodesSequence(?int $modeId, int $bo, Game $game): Collection
    {
        /**
         * If $modeId is null => CLASSIC, else FULL MODE
         */
        if ($modeId) {
            $uniqueGamemode = Gamemode::find($modeId);
            $gamemodes = Collection::times($bo, function () use ($uniqueGamemode) {
                return $uniqueGamemode;
            });
        } else {
            $gamemodes = $game->getClassicModesList()->take($bo);
        }
        return $gamemodes;
    }
    
    /**
     * @param string $rule
     * @param int $nbplayers
     * @param array $playersIds
     * @param Squad $squad
     */
    private function attachSquadMembers(string $rule, int $nbplayers, array $playersIds, Squad $squad): void
    {
        $confirmed = $this->getPlayerConfirmedState($rule);
        
        $members = [];
        for ($i = 0; $i < $nbplayers; $i++) {
            $members[$playersIds[$i]] = ['confirmed' => $confirmed];
        }
        $squad->members()->attach($members);
    }
    
    /**
     * @param string $rule
     *
     * @return bool
     */
    private function getPlayerConfirmedState(string $rule): bool
    {
        if ($rule === 'WAGER') {
            return false;
        }
        return true;
    }
    
    /**
     * @param Request $request
     *
     * @return Game
     */
    private function checkAndReturnGameSelected(Request $request): Game
    {
        /** @var Game $game */
        $game = $request->gameSelected;
        if (!$game) {
            abort(403);
        }
        return $game;
    }
    
    /**
     * @param Collection|User[] $users
     *
     * @throws \Exception
     */
    private function checkUsersNotAlreadyInGame(Collection $users): void
    {
        $playersInGame = [];
        foreach ($users as $user) {
            $blockingMatch = $user->getCurrentMatch();
            
            if ($blockingMatch) {
                $playersInGame[] = $user->username;
            }
        }
        if (count($playersInGame) > 0) {
            throw new \Exception(trans('app.front.trainings.list.modals.errors.players-have-match-in-progress', [
                'usernames' => implode(', ', $playersInGame)
            ]));
        }
    }
    
    /**
     * @param Request $request
     * @param Game $game
     * @param int $bo
     *
     * @throws \Exception
     */
    private function checkMapsSelectedExistInGame(Request $request, Game $game, int $bo): void
    {
        $allGameMapsIds = $game->maps->implode('id', ',');
        $mapRules = [];
        for ($i = 0; $i < $bo; $i++) {
            $mapRules["maps.$i"] = "required|in:{$allGameMapsIds}";
        }
        $validator = Validator::make($request->input(), $mapRules);
        if ($validator->fails()) {
            throw new \Exception(trans('app.front.trainings.list.modals.errors.maps-invalid'));
        }
    }
    
    /**
     * @param Game $game
     * @param int $bo
     * @param iterable $gamemodes
     * @param iterable $mapsIds
     *
     * @throws \Exception
     */
    private function checkMapsGamemodes(Game $game, int $bo, iterable $gamemodes, iterable $mapsIds): void
    {
        $allMaps = $game->maps->keyBy('id');
        $mapsByModes = $game->getMapsByGamemodeId();
        for ($i = 0; $i < $bo; $i++) {
            if (!$mapsByModes[$gamemodes[$i]->id]->contains('id', $mapsIds[$i])) {
                throw new \Exception(trans('app.front.trainings.list.modals.errors.wrong-mode-map', [
                    'map' => $allMaps[$mapsIds[$i]]->name,
                    'mode' => $gamemodes[$i]->name,
                ]));
            }
        }
    }
    
    /**
     * @param int $bet
     * @param Collection|User[] $players
     *
     * @throws \Exception
     */
    private function checkPlayersCredits(int $bet, $players): void
    {
        foreach ($players as $player) {
            if ($player->credits < $bet) {
                throw new \Exception(trans('app.front.trainings.list.modals.errors.player-not-enough-credits', [
                    'username' => $player->username
                ]));
            }
        }
    }
    
    /**
     * @param Collection|User[] $users
     *
     * @throws \Exception
     */
    private function checkCurrentUserInUsers(Collection $users): void
    {
        if (!$users->contains(Auth::user())) {
            throw new \Exception(trans('app.front.trainings.list.modals.errors.you-have-to-participate'));
        }
    }
    
    /**
     * @param Collection|User[] $users
     * @param Team $team
     *
     * @throws \Exception
     */
    private function checkUsersActiveTeam($users, $team): void
    {
        $playersWithAnotherActiveTeam = [];
        
        foreach ($users as $user) {
            if (!$user->activeTeam || $user->activeTeam->id != $team->id) {
                $playersWithAnotherActiveTeam[] = $user->username;
            }
        }
        if (count($playersWithAnotherActiveTeam) > 0) {
            throw new \Exception(trans('app.front.trainings.list.modals.errors.players-active-team-is-not-your-team', [
                'usernames' => implode(', ', $playersWithAnotherActiveTeam)
            ]));
        }
    }
    
    private function checkUsersGameNetworkSet($users, Game $game): void
    {
        $playersWithoutGameNetworkID = [];
        
        foreach ($users as $user) {
            $userNetwork = $user->networks->find($game->network_id);
            if (!$userNetwork || trim($userNetwork->pivot->identifier) == '') {
                $playersWithoutGameNetworkID[] = $user->username;
            }
        }
        if (count($playersWithoutGameNetworkID) > 0) {
            throw new \Exception(trans('app.front.trainings.list.modals.errors.players-have-no-network-id', [
                'usernames' => implode(', ', $playersWithoutGameNetworkID)
            ]));
        }
    }
}
