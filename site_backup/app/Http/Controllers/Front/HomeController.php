<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->gameSelected) {
            return redirect()->to(route_with_subdomain('trainings_main'));
        }
        return view('front.home');
    }
}
