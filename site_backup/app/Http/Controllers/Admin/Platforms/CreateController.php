<?php

namespace App\Http\Controllers\Admin\Platforms;

use App\Http\Requests\PlatformCreateRequest;
use App\Models\Platform;

class CreateController extends BaseController
{
    public function page()
    {
        return view('admin.platforms.create');
    }
    
    public function save(PlatformCreateRequest $request)
    {
        $platform = new Platform();
        $platform->name = $request->name;
        $platform->order = $request->order;
        if ($request->hasFile('logo')) {
            $platform->logo = $request->file('logo');
        }
        $platform->save();
        
        return redirect()->route('admin_platforms_list')->with('success', trans('app.admin.platforms.created'));
    }
}
