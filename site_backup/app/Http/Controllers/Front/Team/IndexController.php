<?php

namespace App\Http\Controllers\Front\Team;

use App\Models\Network;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends BaseTeamController
{
    public function page(Request $request, $subdomain, $teamname)
    {
        $team = $this->loadTeam($teamname);
        
        $networks = [];
        foreach ($team->networks as $network) {
            $networks[$network->name] = [
                'identifier' =>$network->pivot->identifier,
                'logo' =>$network->logo,
            ];
        }
        
        return view('front.team.index', compact('team', 'networks'));
    }

    public function save(Request $request, $subdomain, Team $team)
    {
        $this->authorize('manage', $team);
        
        $this->validate($request, [
            'name' => 'required|string|min:4|max:15|regex:/^[A-Za-z0-9\-\_\ ]+$/|unique:teams,name,' . $team->id,
            'avatar' => 'image|mimes:jpeg,jpg,png',
            'banner' => 'image|mimes:jpeg,jpg,png',
            'description' => 'present|nullable|string|max:200',
            'website' => 'present|nullable|string|url|max:255',
            'networks.twitter' => 'present|nullable|string|max:255',
            'networks.googleplus' => 'present|nullable|string|max:255',
            'networks.facebook' => 'present|nullable|string|url|max:255',
            'networks.youtube' => 'present|nullable|string|url|max:255',
            'networks.twitch' => 'present|nullable|string|url|max:255',
        ]);
        
        $networks = [];
        foreach ($request->input('networks') as $networkName => $networkIdentifier) {
            $network = Network::whereName($networkName)->first();
            if ($network && $networkIdentifier) {
                $networks[$network->id] = ['identifier' => $networkIdentifier];
            }
        }
        $team->networks()->sync($networks);
        
        if ($request->hasFile('avatar')) {
            $team->avatar = $request->file('avatar');
        }
        if ($request->hasFile('banner')) {
            $team->banner = $request->file('banner');
        }
    
        $team->name = $request->input('name');
        $team->slug = str_slug($team->name);
        $team->description = $request->input('description');
        $team->country = $request->input('country');
        $team->website = $request->input('website');
        $team->updated_at = Carbon::now();
        $team->save();
        
        return redirect()->to(route_with_subdomain('team_main', ['name' => $team->slug]))->with('success', trans('app.front.team.updated'));
    }
}
