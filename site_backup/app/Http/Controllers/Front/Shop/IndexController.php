<?php

namespace App\Http\Controllers\Front\Shop;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function page()
    {
        return redirect()->to(route_with_subdomain('shop_premium'));
    }
}
