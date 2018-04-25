<?php

namespace App\Http\Controllers\Admin\Networks;

use App\Http\Requests\NetworkEditRequest;
use App\Models\Network;

class EditController extends BaseController
{
    public function page(Network $network)
    {
        return view('admin.networks.edit', compact('network'));
    }

    public function save(NetworkEditRequest $request, Network $network)
    {
        $network->name = $request->name;
        if ($request->hasFile('logo')) {
            $network->logo = $request->file('logo');
        }
        
        $network->save();

        return redirect()->back()->with('success', trans('app.admin.networks.updated'));
    }
}
