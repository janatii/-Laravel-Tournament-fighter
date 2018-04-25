<?php

namespace App\Http\Controllers\Admin\Networks;

use App\Http\Requests\NetworkCreateRequest;
use App\Models\Network;

class CreateController extends BaseController
{
    public function page()
    {
        return view('admin.networks.create');
    }
    
    public function save(NetworkCreateRequest $request)
    {
        $network = new Network();
        $network->name = $request->name;
        if ($request->hasFile('logo')) {
            $network->logo = $request->file('logo');
        }
        $network->save();
        
        return redirect()->route('admin_networks_list')->with('success', trans('app.admin.networks.created'));
    }
}
