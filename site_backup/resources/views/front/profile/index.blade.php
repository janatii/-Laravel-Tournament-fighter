@extends('front.profile.layout')

@section('sub_content')
    <div class="bloc profil-stat">
        <div class="section-title">
            @lang('app.front.profile.layout.menu.statistiques')
        </div>
        <div class="section-content">
            {{ trans('app.global.generic-texts.coming-soon') }} !
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" style="padding-right: 5px">
            <div class="bloc profil-match-recent">
                <div class="section-title">
                    @lang('app.front.profile.layout.menu.last-matchs')
                </div>
                <div class="section-content">
                    {{ trans('app.global.generic-texts.coming-soon') }} !
                </div>
            </div>
        </div>
        <div class="col-md-6" style="padding-left: 5px">
            <div class="bloc">
                <div class="section-title">
                    @lang('app.front.profile.layout.menu.teams')
                </div>
                <div class="section-content profil-composition">
                    @if($user->activeTeam && $user->activeTeam->game->id === $game_selected->id)
                        <div class="row">
                            <div class="col-sm-4 profil-principal">
                                <a href="{{ route_with_subdomain('team_main', ['teamname' => $user->activeTeam->name]) }}">
                                    <div class="logo-back" style="background-image: url('{{ $user->activeTeam->banner }}')"></div>
                                    <img class="logo-front" src="{{ $user->activeTeam->avatar }}" alt="">
                                    <div class="team-name">{{ $user->activeTeam->name }}</div>
                                </a>
                            </div>
                            <div class="col-sm-7 composition">
                                @foreach($user->activeTeam->members as $member)
                                    @component('components.gamer')
                                        @slot('gamer', $member)
                                        @slot('role', $member->pivot->role)
                                    @endcomponent
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="row profil-equipe">
                        @foreach($teams as $team)
                            @if(!isset($user->activeTeam) || $team->id != $user->activeTeam->id)
                                <div class="col-sm-4">
                                    <a href="{{ route_with_subdomain('team_main', ['teamname' => $team->slug]) }}">
                                        <div class="logo-back" style="background-image: url('{{ $team->banner }}')"></div>
                                        <img class="logo-front" src="{{ $team->avatar }}" alt="">
                                        <div class="team-name">{{ $team->name }}</div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-default btn-sm btn-block" href="{{ route_with_subdomain('profile_teams', ['pseudo' => $user->username]) }}">@lang('app.global.generic-texts.see-more')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection