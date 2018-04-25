<?php

namespace App\Http\Middleware;

use App\Helpers\Facades\LocalizationFormats;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->hasCookie('locale')) {
            $localeToSet = $this->getCookieLanguageAvailable($request);
        } elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $localeToSet = $this->getHTTPPreferredLanguageAvailable($request);
        } else {
            $localeToSet = config('app.fallback_locale');
        }
        
        if (Auth::check()) {
            $user = Auth::user();
            if (isset($user->locale)) {
                $localeToSet = $user->locale;
            }
        }
        
        App::setLocale($localeToSet);
        
        return $next($request);
    }
    
    protected function getHTTPPreferredLanguageAvailable(Request $request)
    {
        // Retrieve languages with order of preference
        $acceptedLanguages = \GuzzleHttp\Psr7\parse_header($request->server('HTTP_ACCEPT_LANGUAGE'));
        foreach ($acceptedLanguages as $key => $acceptedLanguage) {
            if (!isset($acceptedLanguages[$key]['q'])) {
                $acceptedLanguages[$key]['q'] = 1.0;
            } else {
                $acceptedLanguages[$key]['q'] = floatval($acceptedLanguages[$key]['q']);
            }
            if (isset($acceptedLanguages[$key][0])) {
                $acceptedLanguages[$key]['lang'] = $acceptedLanguages[$key][0];
            } elseif (isset($acceptedLanguages[$key][1])) {
                $acceptedLanguages[$key]['lang'] = $acceptedLanguages[$key][1];
            } else {
                $acceptedLanguages[$key]['lang'] = '';
            }
        }
        
        // Sort by preference
        usort($acceptedLanguages, function($a, $b) {
            if ($a['q'] == $b['q']) {
                return 0;
            }
            return ($a['q'] > $b['q']) ? -1 : 1;
        });
    
        $localesAcceptedByApp = LocalizationFormats::getAcceptedLocales();
        
        // Return first available locale
        foreach ($acceptedLanguages as $acceptedLanguage) {
            if (in_array($acceptedLanguage['lang'], $localesAcceptedByApp)) {
                return $acceptedLanguage['lang'];
            }
        }
        
        return null;
    }
    
    protected function getCookieLanguageAvailable(Request $request)
    {
        $cookieLocale = $request->cookie('locale');
        
        if (in_array($cookieLocale, LocalizationFormats::getAcceptedLocales())) {
            return $cookieLocale;
        }
    
        return null;
    }
}
