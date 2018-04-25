<?php

namespace App\Providers;

use App\Helpers\Facades\LocalizationFormats;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) {
            if (empty($parameters)) {
                $user = Auth::user();
            } else {
                $user = User::find($parameters[0]);
            }
            
            return Hash::check($value, $user->password);
        });
        
        Validator::extend('password', function ($attribute, $value, $parameters, $validator) {
            return strlen($value) >= 6;
        });
        
        Validator::extend('locale', function ($attribute, $value, $parameters, $validator) {
            return in_array($value, LocalizationFormats::getAcceptedLocales());
        });
        
        Validator::extend('filter_score', function ($attribute, $value, $parameters, $validator) {
            if (preg_match('/^[0-9]+ \- [0-9]+$/', $value) === false) {
                return false;
            }
            
            list($scoreMin, $scoreMax) = explode(' - ', $value);
            if ($scoreMin > $scoreMax) {
                return false;
            }
            
            return true;
        });
        
        Validator::extend('bet', function ($attribute, $value, $parameters, $validator) {
            return in_array($value, config('app.available_bets'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
