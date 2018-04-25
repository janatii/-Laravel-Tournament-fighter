<div class="gamer-component {{ $gamer->isPremium() ? 'premium' : '' }}">
    <a href="{{ route_with_subdomain('profile_main', ['pseudo' => $gamer->username]) }}">
        <img class="gamer-component__avatar" src="{{ $gamer->avatar }}" alt="">
        <div class="gamer-component__details">
            <div class="gamer-component__details__username">{{ $gamer->username }}</div>
            @isset($role)
                <div class="gamer-component__details__role">{{ trans('app.global.generic-texts.' . strtolower($role)) }}</div>
            @endisset
            @isset($score)
                <div class="gamer-component__details__score">{{ $score }} <i class="fa fa-line-chart"></i></div>
            @endisset
            @isset($network)
                <div class="gamer-component__details__network">
                    <img src="{{ $network->logo }}" alt=""> {{ $network->pivot->identifier }}
                </div>
            @endisset
            @isset($confirmed)
                <div class="gamer-component__details__confirm">{{ $confirmed ? trans('app.global.generic-texts.confirm-play') : trans('app.global.generic-texts.not-confirm-play') }}</div>
            @endisset
        </div>
    </a>
</div>
