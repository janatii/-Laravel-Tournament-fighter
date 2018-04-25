<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Requests\PageCreateRequest;
use App\Models\Page;

class CreateController extends BaseController
{
    public function page()
    {
        return view('admin.pages.create');
    }
    
    public function save(PageCreateRequest $request)
    {
        $page = new Page();
        $page->title = $request->input('title');
        $page->lang = $request->input('lang');
        $page->url = $request->input('url');
        $page->content = $request->input('content');
        $page->order = $request->input('order');
        $page->visible_in_menu = $request->input('visible_in_menu') ? '1' : '0';
        $page->save();
        
        
        return redirect()->route('admin_pages_list')->with('success', trans('app.admin.pages.created'));
    }
}
