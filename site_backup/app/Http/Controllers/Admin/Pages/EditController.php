<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Requests\PageEditRequest;
use App\Models\Page;

class EditController extends BaseController
{
    public function page(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function save(PageEditRequest $request, Page $page)
    {
        $page->title = $request->input('title');
        $page->lang = $request->input('lang');
        $page->url = $request->input('url');
        $page->content = $request->input('content');
        $page->order = $request->input('order');
        $page->visible_in_menu = $request->input('visible_in_menu') ? '1' : '0';
        $page->save();

        return redirect()->back()->with('success', trans('app.admin.pages.updated'));
    }
}
