<?php

namespace App\Http\Middleware;

use App\Exceptions\UserLockedException;
use App\Models\Game;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class GameSubdomainAndTeam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $required
     * @return mixed
     * @throws UserLockedException
     */
    public function handle($request, Closure $next, $required = 'required')
    {
        $gameRequired = $required == 'required';
        
        $gameSelected = $this->retrieveGameFromSubdomain($request);
        
        // Protect routes where a game is required
        if (!$gameSelected && $gameRequired) {
            return $this->redirectToWWWHomeWithError();
        }
        
        if ($gameSelected) {
            if (Auth::check()) {
                $user = Auth::user();
                
                $this->retrieveAndShareTeamsWithViews($user, $gameSelected);
                
                $this->initGameInfos($user, $gameSelected);
                
                $this->initActiveTeam($user, $gameSelected);
                $this->shareActiveTeamWithViews($user);
            }
            
            $request->gameSelected = $gameSelected;
            $this->shareGameWithViews($gameSelected);
        }
        
        if (Auth::check()) {
            $user = Auth::user();
            
            $this->retrieveAndShareMatchInProgressWithViews($user);
        }
        
        return $next($request);
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return Game|null
     */
    private function retrieveGameFromSubdomain(Request $request)
    {
        $subdomain = $request->route('subdomain');
        
        if (isset($subdomain) && $subdomain != 'www') {
            return Game::whereSubdomain($subdomain)->first();
        }
        return null;
    }
    
    private function redirectToWWWHomeWithError()
    {
        session()->flash('error-modal', trans('app.front.home.modals.select-game.title'));
        return redirect()->to(route('home', ['subdomain' => 'www']));
    }
    
    /**
     * @param $gameSelected
     */
    private function shareGameWithViews(Game $gameSelected): void
    {
        View::composer('*', function (ViewContract $view) use ($gameSelected) {
            $view->with('game_selected', $gameSelected);
        });
    }
    
    private function retrieveAndShareTeamsWithViews(User $user, Game $gameSelected): void
    {
        $userTeamsForSelectedGame = $user->teamsByGame($gameSelected)->get();
        
        View::composer('*', function (ViewContract $view) use ($userTeamsForSelectedGame) {
            $view->with('game_teams', $userTeamsForSelectedGame);
        });
    }
    
    /**
     * @param $user
     */
    private function shareActiveTeamWithViews(User $user): void
    {
        View::composer('*', function (ViewContract $view) use ($user) {
            $view->with('active_team', $user->activeTeam);
        });
    }
    
    /**
     * Init game data for this user if necessary (score, etc)
     *
     * @param $user
     * @param $gameSelected
     */
    private function initGameInfos(User $user, Game $gameSelected): void
    {
        $gameWithInfos = $user->games()->find($gameSelected->id);
        if (!$gameWithInfos) {
            $user->initGameInfos($gameSelected);
        }
    }
    
    /**
     * Set active team to first user team in game if active team is null
     *
     * @param $user
     * @param $gameSelected
     */
    private function initActiveTeam(User $user, Game $gameSelected): void
    {
        $activeTeam = $user->activeTeam;
        if (!$activeTeam) {
            $firstTeamInGameSelected = $user->teamsByGame($gameSelected)->first();
            if ($firstTeamInGameSelected) {
                $user->activeTeam()->associate($firstTeamInGameSelected);
                $user->save();
            }
        }
    }
    
    private function retrieveAndShareMatchInProgressWithViews(User $user): void
    {
        $match = $user->getCurrentMatch();
        
        if ($match && ($match->status == 'IN_PROGRESS' || $match->status == 'WAIT_JOIN' || $match->status == 'WAIT_CONFIRM')) {
            View::composer('*', function (ViewContract $view) use ($match) {
                $view->with('match_in_progress', $match);
            });
        }
    }
}
