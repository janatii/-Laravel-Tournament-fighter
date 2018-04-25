<?php

namespace App\Http\Controllers\Front\Team;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembersController extends BaseTeamController
{
    public function index(Request $request, $subdomain, $teamname)
    {
        $team = $this->loadTeam($teamname);
        
        return view('front.team.members', compact('team'));
    }
    
    public function candidate(Request $request, $subdomain, Team $team)
    {
        $this->authorize('join', $team);
        
        $team->candidates()->attach(Auth::user());
        
        return back();
    }
    
    public function abortCandidate(Request $request, $subdomain, Team $team)
    {
        $team->candidates()->detach(Auth::user());
        
        return back();
    }
    
    public function leave(Request $request, $subdomain, Team $team)
    {
        $this->authorize('leave', $team);
        
        $team->members()->detach(Auth::user());
        
        $team->recalculateScore();
        
        return back();
    }
    
    public function acceptCandidate(Request $request, $subdomain, Team $team, User $user)
    {
        $this->authorize('manage', $team);
        if (!$user->can('be-accepted', $team)) {
            abort(403);
        }
    
        $team->bans()->detach($user);
        $team->invites()->detach($user);
        $team->candidates()->detach($user);
        
        $team->members()->attach($user);
        
        $team->recalculateScore();
        
        return back();
    }
    
    public function denyCandidate(Request $request, $subdomain, Team $team, User $user)
    {
        $this->authorize('manage', $team);
        
        $team->candidates()->detach($user);
        
        return back();
    }
    
    public function promoteManager(Request $request, $subdomain, Team $team, User $user)
    {
        $this->authorize('manage-managers', $team);
        
        $user->teams()->updateExistingPivot($team->id, ['role' => 'MANAGER']);
        
        return back();
    }
    
    public function promotePlayer(Request $request, $subdomain, Team $team, User $user)
    {
        $this->authorize('manage-managers', $team);
        
        $user->teams()->updateExistingPivot($team->id, ['role' => 'PLAYER']);
        
        return back();
    }
    
    public function removePlayer(Request $request, $subdomain, Team $team, User $user)
    {
        $this->authorize('manage', $team);
        
        $user->teams()->detach($team->id);
        
        $team->recalculateScore();
        
        return back();
    }
    
    public function addInvite(Request $request, $subdomain, Team $team)
    {
        $this->authorize('invite-players', $team);
        
        $this->validate($request, [
            'username' => 'required|max:15|alpha_dash',
        ]);
        
        $userToInvite = User::where('username', $request->input('username'))->first();
        if (!$userToInvite) {
            return response(['username' => [trans('app.front.team.members.modals.invite-player.errors.user-dont-exists')]], 422);
        }
        if ($team->invites->contains($userToInvite)) {
            return response(['username' => [trans('app.front.team.members.modals.invite-player.errors.user-already-invited')]], 422);
        }
        if ($team->members->contains($userToInvite)) {
            return response(['username' => [trans('app.front.team.members.modals.invite-player.errors.user-already-member')]], 422);
        }
        if (!$userToInvite->can('be-invited', $team)) {
            abort(403);
        }
        
        $team->bans()->detach($userToInvite);
        $team->candidates()->detach($userToInvite);
        
        $team->invites()->attach($userToInvite->id);
        
        return response()->json(['message' => 'success']);
    }
    
    public function addInviteById(Request $request, $subdomain, Team $team, User $user)
    {
        $this->authorize('invite-players', $team);
        
        if (!$user->can('be-invited', $team)) {
            abort(403);
        }
        
        $team->bans()->detach($user);
        $team->candidates()->detach($user);
        
        $team->invites()->attach($user->id);
        
        return back();
    }
    
    public function removeInvite(Request $request, $subdomain, Team $team, User $user)
    {
        $this->authorize('manage', $team);
        
        $team->invites()->detach($user);
    
        return back();
    }
    
    public function acceptInvite(Request $request, $subdomain, Team $team)
    {
        $guest = Auth::user();
        
        $this->authorize('accept-invite', $team);
        
        if (!$guest->can('be-accepted', $team)) {
            abort(403);
        }
    
        $team->bans()->detach($guest);
        $team->invites()->detach($guest);
        $team->candidates()->detach($guest);
        $team->members()->attach($guest);
        
        $team->recalculateScore();
        
        return back();
    }
    
    public function declineInvite(Request $request, $subdomain, Team $team)
    {
        $guest = Auth::user();
        
        $this->authorize('decline-invite', $team);
        
        $team->invites()->detach($guest);
        
        return back();
    }
    
    public function banPlayer(Request $request, $subdomain, Team $team, User $user)
    {
        $this->authorize('ban-players', $team);
        
        $team->invites()->detach($user);
        $team->candidates()->detach($user);
        $team->members()->detach($user);
        
        $team->bans()->attach($user);
        
        $team->recalculateScore();
        
        return back();
    }
    
    public function unbanPlayer(Request $request, $subdomain, Team $team, User $user)
    {
        $this->authorize('unban-players', $team);
        
        $team->bans()->detach($user);
        
        return back();
    }
}
