@extends('front.layout')

@section('content')
    <div class="bancanopy">
        <div class="bancanopy-inner">
            <div class="bancanopy-header">
                <div class="bancanopy-header-bg" style="background-image: url('{{ $match->game->banner }}')"></div>
            </div>
        </div>
    </div>

    <!-- MAIN-CONTENT -->
    <div class="main-content-wrapper">
        <div class="container">
            <div class="row mid-wrapper">
                <!--Main-->
                <div class="col-lg-9 middle-main">
    
                    <!-- Ongoing Match -->
                    <div class="bloc ongoing-match">
                        <div class="section-title">
                            {{ trans('app.global.generic-texts.match-in-progress') }}
                        </div>
                        <div class="section-content">
                            <div class="row">
                                <!-- Team Left -->
                                <div class="col-md-6 team-wrapper">
                                    <div class="row team-header left">
                                        <div class="col-sm-12">
                                            <a href="{{ route_with_subdomain('team_main', ['name' => $match->squad1->team->name]) }}">
                                                <img class="team-logo" src="{{ $match->squad1->team->avatar }}" alt="">
                                                <div class="team-name">{{ $match->squad1->team->name }}</div>
                                            </a>
                                            <div class="team-classement">
                                                {{ $match->squad1->team->score }} <i class="fa fa-line-chart"></i>
                                            </div>
                                            @if($match->status == 'FINISH')
                                                <div>
                                                    {{ $match->win_squad_id == $match->squad1_id ? trans('winner') : trans('loser') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                   <div class="row team-gamers-container left">
                                        <div class="col-sm-12">
                                            <div class="team-manager">
                                                <div class="title-manager-squad">{{ trans('app.global.generic-texts.manager') }}</div>
                                                <div class="list-squad-players">
                                                    <a href="{{ route_with_subdomain('profile_main', ['username' => $match->squad1->manager->username]) }}">
                                                        @component('components.gamer')
                                                            @slot('gamer', $match->squad1->manager)
                                                            @slot('network', $match->squad1->manager->networks->find($match->game->network_id))
                                                        @endcomponent
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="team-gamer">
                                                <div class="title-players-squad">{{ trans('app.global.generic-texts.players') }}</div>
                                                <div class="list-squad-players">
                                                    @foreach($match->squad1->members as $member)
                                                        <a href="{{ route_with_subdomain('profile_main', ['username' => $member->username]) }}">
                                                            @component('components.gamer')
                                                                @slot('gamer', $member)
                                                                @slot('score', $member->getScore($match->game))
                                                                @slot('network', $member->networks->find($match->game->network_id))
                                                                @slot('confirmed', $member->pivot->confirmed)
                                                            @endcomponent
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- End Team Left -->
    
                                <div class="versus">
                                    <img src="/img/icon-vs.gif" alt="">
                                </div>
    
                                <!-- Team Right -->
                                <div class="col-md-6 team-wrapper">
                                    <div class="row team-header right">
                                        <div class="col-sm-12">
                                            <a href="{{ route_with_subdomain('team_main', ['name' => $match->squad2->team->name]) }}">
                                                <img class="team-logo" src="{{ $match->squad2->team->avatar }}" alt="">
                                                <div class="team-name">{{ $match->squad2->team->name }}</div>
                                            </a>
                                            <div class="team-classement">
                                                {{ $match->squad2->team->score }} <i class="fa fa-line-chart"></i>
                                            </div>
                                            @if($match->status == 'FINISH')
                                                <div>
                                                    {{ $match->win_squad_id == $match->squad2_id ? trans('winner') : trans('loser') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row team-gamers-container right">
                                        <div class="col-sm-12">
                                            <div class="team-manager">
                                                <div class="title-manager-squad">{{ trans('app.global.generic-texts.manager') }}</div>
                                                <div class="list-squad-players">
                                                    <a href="{{ route_with_subdomain('profile_main', ['username' => $match->squad2->manager->username]) }}">
                                                        @component('components.gamer')
                                                            @slot('gamer', $match->squad2->manager)
                                                            @slot('network', $match->squad2->manager->networks->find($match->game->network_id))
                                                        @endcomponent
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="team-gamer">
                                                <div class="title-players-squad">{{ trans('app.global.generic-texts.players') }}</div>
                                                <div class="list-squad-players">
                                                    @foreach($match->squad2->members as $member)
                                                        <a href="{{ route_with_subdomain('profile_main', ['username' => $member->username]) }}">
                                                            @component('components.gamer')
                                                                @slot('gamer', $member)
                                                                @slot('score', $member->getScore($match->game))
                                                                @slot('network', $member->networks->find($match->game->network_id))
                                                                @slot('confirmed', $member->pivot->confirmed)
                                                            @endcomponent
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- End Team Right -->
                            </div>
                        </div>
                    </div> <!-- End Ongoing Match -->
    
                    @if($match->status == 'WAIT_CONFIRM')
                        @if(Auth::check() && ($match->squad1->notConfirmedMembers->contains(Auth::user()) || $match->squad2->notConfirmedMembers->contains(Auth::user())))
                            <div class="bloc confirm-wager">
                                <div class="section-title">
                                    {{ trans('app.front.trainings.show.confirm-your-participation') }}
                                </div>
                                <div class="section-content">
                                    <form action="{{ route_with_subdomain('training_confirm', ['match' => $match]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}
                                        <button type="submit" name="validation_status" value="deny" class="btn btn-danger">{{ trans('app.front.trainings.show.deny-particpation') }}</button>
                                        <button type="submit" name="validation_status" value="accept" class="btn btn-success">{{ trans('app.front.trainings.show.accept-participation', ['bet' => bet_text($match->bet)]) }}</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endif
                    
                    @if($match->status == 'IN_PROGRESS')
                        @if(isset($match->ask_cancel_squad_id))
                            <div class="bloc confirm-cancel">
                                <div class="section-title">
                                    {{ trans('app.front.trainings.show.match-cancellation') }}
                                </div>
                                <div class="section-content">
                                    @if($match->squad1->manager_id == Auth::id() || $match->squad2->manager_id == Auth::id())
                                        @if($match->ask_cancel_squad_id == $mySquadID)
                                            <p>
                                                {{ trans('app.front.trainings.show.you-asked-cancel-wait-other-manager') }}
                                            </p>
                                        @else
                                            <form action="{{ route_with_subdomain('training_cancel_confirm', ['match' => $match]) }}" method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('PATCH') }}
                                                
                                                <p>
                                                    {{ trans('app.front.trainings.show.other-team-want-cancel-what-do-you-want') }}
                                                </p>
                                                
                                                <button type="submit" name="cancel_validation_status" value="deny" class="btn btn-succes">{{ trans('app.front.trainings.show.continue-match') }}</button>
                                                <button type="submit" name="cancel_validation_status" value="accept" class="btn btn-danger">{{ trans('app.front.trainings.show.cancel-match') }}</button>
                                            </form>
                                        @endif
                                    @else
                                        @if($match->ask_cancel_squad_id == $mySquadID)
                                            <p>
                                                {{ trans('app.front.trainings.show.your-manager-asked-cancellation') }}
                                            </p>
                                        @else
                                            <p>
                                                
                                                {{ trans('app.front.trainings.show.other-manager-asked-cancellation') }}
                                            </p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @elseif(isset($match->ask_cancel_accepted, $match->cancel_confirm_user_id))
                            <div class="bloc confirm-cancel">
                                <div class="section-title">
                                    {{ trans('app.front.trainings.show.match-cancellation') }}
                                </div>
                                <div class="section-content">
                                    @if($match->ask_cancel_accepted)
                                        <p>{{ trans('app.front.trainings.show.user-cancelled-match', ['username' => $match->cancelConfirmUser->username]) }}</p>
                                    @else
                                        <p>{{ trans('app.front.trainings.show.user-deny-to-cancel-match', ['username' => $match->cancelConfirmUser->username]) }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
                    
                    @if(in_array($match->status, ['WAIT_CONFIRM', 'IN_PROGRESS', 'ABORTED', 'FINISH']))
                        <!-- Rounds Details -->
                        <div class="bloc details-round">
                            <div class="section-title">
                                {{ trans('app.front.trainings.show.rounds-details') }}
                            </div>
                            
                            @foreach($match->rounds as $round)
                                @unless($match->status == 'FINISH' && !$round->haveResults())
                                    <div class="section-content">
                                        <div class="row">
                                            <div class="col-md-4 left">
                                                <div class="top">
                                                    <span class="team-logo"><img src="{{ $match->squad1->team->avatar }}" alt=""></span>
                                                    <span class="team-name">{{ $match->squad1->team->name }}</span>
                                                </div>
                                                <div class="middle">
                                                    @isset($round->end_at)
                                                        @if(\Carbon\Carbon::now()->gte($round->end_at) || $round->haveResults())
                                                            @if($round->haveResults())
                                                                @if($round->wasWinBySquad1())
                                                                    <img src="/img/round-win/{{ ($match->id + random_int(0, 100)) % 3 }}_{{ App::getLocale() }}.gif" alt="">
                                                                @else
                                                                    <img src="/img/round-lose/{{ ($match->id + random_int(0, 100)) % 3 }}_{{ App::getLocale() }}.gif" alt="">
                                                                @endif
                                                            @elseif($round->needReferee())
                                                                <p>{{ trans('app.global.generic-texts.wait-referee') }}</p>
                                                            @elseif(!isset($round->win_squad_sent_by_squad1_id))
                                                                <p>{{ trans('app.global.generic-texts.wait-results') }}</p>
                                                            @endif
                                                        @elseif(isset($round->end_at))
                                                            <i class="fa fa-lock"></i>
                                                            <p>{{ trans('app.front.trainings.show.this-round-will-be-unlocked-in') }} <span class="roundCountdown" data-time-end="{{ $round->end_at->format('Y/m/d H:i:s') }}"></span></p>
                                                        @endif
                                                    @endisset
                                                </div>
                                            </div>
                                            <div class="col-md-4 center">
                                                <p>{{ trans('app.global.generic-texts.round') }} {{ $loop->iteration }}</p>
                                                <div class="map">
                                                    <img src="{{ $round->map->logo }}" alt="">
                                                    <div class="map-name">
                                                        {{ $round->map->name }}
                                                    </div>
                                                </div>
                                                <div class="gamemode">
                                                    {{ trans('app.global.generic-texts.mode') }}: {{ $round->gamemode->name }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 right">
                                                <div class="top">
                                                    <span class="team-logo"><img src="{{ $match->squad2->team->avatar }}" alt=""></span>
                                                    <span class="team-name">{{ $match->squad2->team->name }}</span>
                                                </div>
                                                <div class="middle">
                                                    @isset($round->end_at)
                                                        @if(\Carbon\Carbon::now()->gte($round->end_at) || $round->haveResults())
                                                            @if($round->haveResults())
                                                                @if($round->wasWinBySquad2())
                                                                    <img src="/img/round-win/{{ ($match->id + random_int(0, 100)) % 3 }}_{{ App::getLocale() }}.gif" alt="">
                                                                @else
                                                                    <img src="/img/round-lose/{{ ($match->id + random_int(0, 100)) % 3 }}_{{ App::getLocale() }}.gif" alt="">
                                                                @endif
                                                            @elseif($round->needReferee())
                                                                <p>{{ trans('app.global.generic-texts.wait-referee') }}</p>
                                                            @elseif(!isset($round->win_squad_sent_by_squad2_id))
                                                                <p>{{ trans('app.global.generic-texts.wait-results') }}</p>
                                                            @endif
                                                        @elseif(isset($round->end_at))
                                                            <i class="fa fa-lock"></i>
                                                            <p>{{ trans('app.front.trainings.show.this-round-will-be-unlocked-in') }} <span class="roundCountdown" data-time-end="{{ $round->end_at->format('Y/m/d H:i:s') }}"></span></p>
                                                        @endif
                                                    @endisset
                                                </div>
                                            </div>
                                        </div>
                                        @if($match->status == 'IN_PROGRESS')
                                            @hasanyrole(['superadmin', 'admin', 'referee'])
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-4 text-center">
                                                        <div style="padding: 10px 0 0 0">
                                                            <form method="post" action="{{ route_with_subdomain('training_arbitrate_round', ['match' => $match, 'round' => $round]) }}">
                                                                {{ csrf_field() }}
                                                                {{ method_field('PATCH') }}
                                                                
                                                                <button type="submit" name="winning_squad" value="{{ $match->squad1_id }}" class="btn btn-primary">Team 1 WIN</button>
                                                                <button type="submit" name="winning_squad" value="{{ $match->squad2_id }}" class="btn btn-danger">Team 2 WIN</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                @if(isset($round->end_at) && \Carbon\Carbon::now()->gte($round->end_at))
                                                    @if(($match->squad1->manager_id == Auth::id() && !isset($round->win_squad_sent_by_squad1_id)) || ($match->squad2->manager_id == Auth::id() && !isset($round->win_squad_sent_by_squad2_id)))
                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-4 text-center">
                                                                <div style="padding: 10px 0 0 0">
                                                                    <form method="post" action="{{ route_with_subdomain('training_send_score_round', ['match' => $match, 'round' => $round]) }}">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('PATCH') }}
                                                                        
                                                                        <button type="submit" name="winning_squad" value="{{ $mySquadID }}" class="btn btn-primary">{{ trans('app.global.generic-texts.i-win') }}</button>
                                                                        <button type="submit" name="winning_squad" value="{{ $otherSquadID }}" class="btn btn-danger">{{ trans('app.global.generic-texts.i-lost') }}</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endhasanyrole
                                        @endif
                                    </div>
                                @endunless
                            @endforeach
                        </div> <!-- End Rounds Details -->
                    @endif
    
                    <!-- General Rules -->
                    <a class="anchor" name="rules"></a>
                    <div class="bloc">
                        <div class="section-title">
                            {{ trans('app.global.generic-texts.rules') }}
                        </div>
                        <div class="section-content">
                            {!! $match->game->rules !!}
                        </div>
                    </div> <!-- End General Rules -->
    
                </div> <!-- End Main-->
    
                <!--Sidebar-->
                <div class="col-lg-3 middle-sidebar">
                    
                    @if($match->type == 'WAGER')
                        <div class="bloc bet-wrapper">
                            <div class="section-content">
                                <div class="bet-container">
                                    <div class="title">
                                        <span>{{ matchtype_text($match->type) }} $</span>
                                    </div>
                                    <div class="gold credits">
                                        @if(Auth::guest() || (Auth::check() && Auth::user()->isPremium()))
                                            {{ bet_text($match->creditsToWinForPremium()) }}
                                        @else
                                            {{ bet_text($match->creditsToWinForNonPremium()) }}
                                        @endif
                                    </div>
                                    <div class="towin">{{ trans('app.front.trainings.show.to-win') }}</div>
                                </div>
                                @if(Auth::check() && !Auth::user()->isPremium())
                                    <div class="become-premium">
                                        <a href="{{ route_with_subdomain('shop_premium') }}" class="premium">
                                            <img class="premium-icon" src="/img/premium-icon.png" alt=""> {{ trans('app.front.trainings.show.become-premium-to-win-more') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <div class="bloc training-detail-wrapper">
                        <div class="section-content training-detail">
                            <div class="top">
                                <span>{{ trans('app.front.trainings.show.training-details-title') }}</span>
                            </div>
                            <div>
    
                            </div>
                            <div class="middle">
                                <div class="middle-col-1"><span>{{ matchtype_text($match->type) }}</span></div>
                                <div class="middle-col-2"><span>{{ $match->full_gamemode_id ? $match->fullGamemode->name : trans('app.global.generic-texts.classic') }}</span></div>
                            </div>
                            <div class="middle">
                                <div class="middle-col-1"><span>{{ bestof_text($match->bo) }}</span></div>
                                <div class="middle-col-2"><span>{{ versus_text($match->vs) }}</span></div>
                            </div>
                            <div class="bottom">
                                <span>ID : #{{ $match->id }}</span>
                            </div>
                        </div>
                    </div>
    
                    <div class="bloc link-detail">
                        <a href="#rules" class="btn btn-primary btn-block button">
                            {{ trans('app.front.trainings.show.see-rules-and-details') }}
                        </a>
                    </div>
                    
                    @if($match->status == 'IN_PROGRESS')
                        @if($match->squad1->manager_id == Auth::id() || $match->squad2->manager_id == Auth::id())
                            @if(!isset($match->ask_cancel_squad_id))
                                <div class="bloc link-cancel">
                                    <form action="{{ route_with_subdomain('training_cancel_ask', ['match' => $match]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}
                                        
                                        <button type="submit" class="btn btn-primary btn-block button">
                                            {{ trans('app.front.trainings.show.ask-to-cancel') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                            @if($match->wait_referee)
                                <div class="bloc link-call">
                                    <button type="submit" class="btn btn-danger btn-block button">
                                        {{ trans('app.front.trainings.show.referee-was-called') }}
                                    </button>
                                </div>
                            @else
                                <div class="bloc link-call">
                                    <form action="{{ route_with_subdomain('training_ask_referee', ['match' => $match]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}
                                        
                                        <button type="submit" class="btn btn-danger btn-block button">
                                            {{ trans('app.front.trainings.show.call-referee') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @else
                            @hasanyrole(['superadmin', 'admin', 'referee'])
                                <div class="bloc link-cancel">
                                    <form action="{{ route_with_subdomain('training_cancel', ['match' => $match]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}
                                        
                                        <button type="submit" class="btn btn-danger btn-block button">
                                            {{ trans('app.front.trainings.show.cancel-match') }}
                                        </button>
                                    </form>
                                </div>
                            @endhasanyrole
                        @endif
                    @elseif($match->status == 'WAIT_CONFIRM')
                        @if($match->squad1->manager_id == Auth::id() || $match->squad2->manager_id == Auth::id())
                            <div class="bloc link-cancel">
                                <form action="{{ route_with_subdomain('training_cancel', ['match' => $match]) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    
                                    <button type="submit" class="btn btn-danger btn-block button">
                                        {{ trans('app.front.trainings.show.cancel-match') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endif
                    
                </div> <!-- End Sidebar -->
            </div>
        </div>
    </div>
    <!-- END MAIN-CONTENT -->
    @if(Auth::check() && Auth::user()->canSeeChat($match))
        <chat :closed="{{ !in_array($match->status, ['IN_PROGRESS', 'WAIT_CONFIRM']) && ($match->status != 'FINISH' || $match->updated_at->lt(\Carbon\Carbon::now()->subHours(12))) ? 'true' : 'false' }}" :match_id="{{ $match->id }}" :squad1_id="{{ $match->squad1_id }}" :squad2_id="{{ $match->squad2_id }}"></chat>
    @endif
    
    @if($match->status == 'FINISH')
        <div class="remodal" data-remodal-id="win-modal" role="alert" data-remodal-options="hashTracking: false">
            <button data-remodal-action="close" class="remodal-close"></button>
        
            <h1 class="text-center">
                @lang('app.global.generic-texts.match-end')
            </h1>
        
            <p>
                {{ trans('app.front.trainings.show.team-won-match', ['team' => $match->winSquad->team->name]) }}
            </p>
            
            <button data-remodal-action="confirm" type="button" class="btn btn-success">@lang('app.global.generic-texts.ok')</button>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="/vendor/jquery.countdown/jquery.countdown.min.js"></script>
    <script>
        (function() {
            $(".roundCountdown").each(function() {
                $(this).countdown($(this).data('time-end'), function(e) {
                    $(this).text(e.strftime('%-M\'%S"'));
                    
                    $(this).on('finish.countdown', function() {
                        window.location.reload();
                    });
                });
            });
            
            @if($match->status == 'FINISH')
                var $winRemodal = $('[data-remodal-id="win-modal"]');
                var $remodalObj = $winRemodal.remodal();
                $remodalObj.settings.hashTracking = false;
                $remodalObj.open();
            @endif
        })();
    </script>
@endpush