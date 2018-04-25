<div class="team-component">
    <a href="{{ route_with_subdomain('team_main', ['name' => $team->slug]) }}">
        <img class="team-component__avatar" src="{{ $team->avatar }}" alt="">
        <div class="team-component__details">
            <div class="team-component__details__name">{{ $team->name }}</div>
            @isset($score)
                <div class="team-component__details__score">{{ $score }} <i class="fa fa-line-chart"></i></div>
            @endisset
        </div>
    </a>
</div>
