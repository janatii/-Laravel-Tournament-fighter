<?php

namespace App\Http\Controllers\Front\Profile;

use App\Models\Network;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IndexController extends BaseProfileController
{
    public function page(Request $request, $subdomain, $pseudo)
    {
        $user = $this->loadUser($pseudo);
        
        $networks = [];
        foreach ($user->networks as $network) {
            $networks[$network->name] = [
                'identifier' =>$network->pivot->identifier,
                'logo' =>$network->logo,
            ];
        }
        
        // TODO: Trier par fréquence d'utilisation
        $teams = $user->teams()->with('members')->where('game_id', $request->gameSelected->id)->limit(3)->get();
        
        $score = $user->getScore($request->gameSelected);
        
        return view('front.profile.index', compact('user', 'networks', 'teams', 'score'));
    }

    public function save(Request $request, $subdomain, User $user)
    {
        $this->authorize('update', $user);
        
        $this->validate($request, [
            'avatar' => 'image|mimes:jpeg,jpg,png',
            'banner' => 'image|mimes:jpeg,jpg,png',
            'gender' => 'present|nullable|string|max:1|in:m,f',
            'description' => 'present|nullable|string|max:200',
            'country' => 'present|nullable|string|max:255',
            'website' => 'present|nullable|string|url|max:255',
            'networks.playstation' => 'present|nullable|string|max:255',
            'networks.xbox' => 'present|nullable|string|max:255',
            'networks.steam' => 'present|nullable|string|max:255',
            'networks.battletag' => 'present|nullable|string|max:15',
            'networks.uplay' => 'present|nullable|string|max:15',
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
        $user->networks()->sync($networks);
        
        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar');
        }
        if ($request->hasFile('banner')) {
            $user->banner = $request->file('banner');
        }
        
        $user->gender = $request->input('gender');
        $user->description = $request->input('description');
        $user->country = $request->input('country');
        $user->website = $request->input('website');
        $user->updated_at = Carbon::now();
        $user->save();
        
        return redirect()->back()->with('success', trans('app.front.profile.updated'));
    }
}
