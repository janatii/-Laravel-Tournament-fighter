<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Models\Page;

class DeleteController extends BaseController
{
    public function delete(Page $page)
    {
        $page->delete();
        
        return redirect()->back()->with('success', trans('app.admin.pages.deleted'));
    }
}
