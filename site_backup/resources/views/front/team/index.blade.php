@extends('front.team.layout')

@section('sub_content')
    <div class="bloc profil-stat">
        <div class="section-title">
            @lang('app.front.team.layout.menu.statistiques')
        </div>
        <div class="section-content">
            {{ trans('app.global.generic-texts.coming-soon') }} !
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" style="padding-right: 5px">
            <div class="bloc profil-match-recent">
                <div class="section-title">
                    @lang('app.front.team.layout.menu.last-matchs')
                </div>
                <div class="section-content">
                    {{ trans('app.global.generic-texts.coming-soon') }} !
                </div>
            </div>
        </div>
        <div class="col-md-6" style="padding-left: 5px">
            <div class="bloc">
                <div class="section-title">
                    @lang('app.front.team.layout.menu.members')
                </div>
                <div class="section-content profil-composition">
                    <div class="row">
                        <div class="composition">
                            @foreach($team->members as $member)
                                @component('components.gamer')
                                    @slot('gamer', $member)
                                    @slot('role', $member->pivot->role)
                                @endcomponent
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-default btn-sm btn-block" href="{{ route_with_subdomain('team_members', ['teamname' => $team->slug]) }}">@lang('app.global.generic-texts.see-more')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection