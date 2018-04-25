<?php

if (! function_exists('route_with_subdomain')) {
    /**
     * Generate the URL to a named route with the current subdomain.
     *
     * @param  string  $name
     * @param  array   $parameters
     * @param  bool    $absolute
     * @return string
     */
    function route_with_subdomain($name, $parameters = [], $absolute = true)
    {
        $subdomain = app('request')->route('subdomain');
        if (!$subdomain) {
            $subdomain = 'www';
        }
        $parameters = $parameters + ['subdomain' => $subdomain];
        
        return app('url')->route($name, $parameters, $absolute);
    }
}

if (! function_exists('versus_text')) {
    function versus_text($nbPlayers)
    {
        return $nbPlayers . 'v' . $nbPlayers;
    }
}

if (! function_exists('bestof_text')) {
    function bestof_text($nbRoundsMax)
    {
        return 'BO' . $nbRoundsMax;
    }
}

if (! function_exists('matchtype_text')) {
    function matchtype_text($type)
    {
        return trans('app.global.generic-texts.' . strtolower($type));
    }
}

if (! function_exists('bet_text')) {
    function bet_text($bet)
    {
        if ($bet) {
            return $bet . 'C';
        }
        return trans('app.global.generic-texts.free');
    }
}