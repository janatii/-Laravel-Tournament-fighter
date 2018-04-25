<?php

namespace App\Providers;

use App\Models\Game;
use App\Models\Map;
use App\Models\Network;
use App\Models\Platform;
use App\Models\Team;
use App\Models\User;
use App\Observers\UploadablesObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        Cashier::useCurrency('eur', '€');
        
        View::composer('front.layout', function (\Illuminate\Contracts\View\View $view) {
            $view->with('menu_games', $this->getPlatformsWithGames());
        });
    
        User::observe(UploadablesObserver::class);
        Team::observe(UploadablesObserver::class);
        Platform::observe(UploadablesObserver::class);
        Game::observe(UploadablesObserver::class);
        Network::observe(UploadablesObserver::class);
        Map::observe(UploadablesObserver::class);
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() === 'local') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(\Laravel\Dusk\DuskServiceProvider::class);
        }
    }
    
    protected function getPlatformsWithGames()
    {
        return Platform::with('games')->whereHas('games', function ($query) {
            $query->where('published', 1);
        })->orderBy('order')->get();
    }
}
