<?php

namespace App\Http\Controllers\Admin\Networks;

use App\Models\Network;

class DeleteController extends BaseController
{
    public function delete(Network $network)
    {
        $network->delete();
        
        return redirect()->back()->with('success', trans('app.admin.networks.deleted'));
    }
}
