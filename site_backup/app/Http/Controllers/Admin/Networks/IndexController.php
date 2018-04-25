<?php

namespace App\Http\Controllers\Admin\Networks;

use App\Models\Network;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        $networks = Network::all();
        
        return view('admin.networks.index', compact('networks'));
    }
}
