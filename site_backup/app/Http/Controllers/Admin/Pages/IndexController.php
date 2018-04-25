<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Models\Page;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        $pages = Page::orderBy('order')->get();
        
        return view('admin.pages.index', compact('pages'));
    }
}
