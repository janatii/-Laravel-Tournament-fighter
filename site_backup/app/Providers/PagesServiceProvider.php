<?php

namespace App\Providers;

use App\Models\Page;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class PagesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('front.layout', function (\Illuminate\Contracts\View\View $view) {
            $pages = Page::where('lang', App::getLocale())->orderBy('order')->get();
            
            $view->with('menu_pages', $pages);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    
    }
}
