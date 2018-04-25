<?php

namespace App\Http\Controllers\Admin\Platforms;

use App\Models\Platform;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        $platforms = Platform::orderBy('order')->get();
        
        return view('admin.platforms.index', compact('platforms'));
    }
}
