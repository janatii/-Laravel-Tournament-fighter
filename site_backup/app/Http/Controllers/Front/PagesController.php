<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function getPage(Request $request, $subdomain, string $url)
    {
        $urlToSearch = '/'. $url;
        
        $page = Page::where('url', $urlToSearch)->firstOrFail();
        
        return response()->view('front.page', compact('page'));
    }
}
