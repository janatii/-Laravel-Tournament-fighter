<?php

namespace App\Http\Controllers\Admin\Platforms;

use App\Http\Requests\PlatformEditRequest;
use App\Models\Platform;

class EditController extends BaseController
{
    public function page(Platform $platform)
    {
        return view('admin.platforms.edit', compact('platform'));
    }

    public function save(PlatformEditRequest $request, Platform $platform)
    {
        $platform->name = $request->name;
        $platform->order = $request->order;
        if ($request->hasFile('logo')) {
            $platform->logo = $request->file('logo');
        }
        
        $platform->save();

        return redirect()->back()->with('success', trans('app.admin.platforms.updated'));
    }
}
