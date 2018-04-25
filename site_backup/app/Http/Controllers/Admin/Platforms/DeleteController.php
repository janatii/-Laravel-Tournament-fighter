<?php

namespace App\Http\Controllers\Admin\Platforms;

use App\Models\Platform;

class DeleteController extends BaseController
{
    public function delete(Platform $platform)
    {
        $platform->delete();
        
        return redirect()->back()->with('success', trans('app.admin.platforms.deleted'));
    }
}
