@extends('front.profile.layout')

@section('sub_content')
    <div class="bloc">
        <div class="section-title">
            @lang('app.front.profile.teams.title')
            @if($user->id === Auth::id())
                @can('create-team', $game_selected)
                    <button class="btn btn-primary pull-right" data-remodal-target="create-team">
                        @lang('app.front.profile.teams.create-team')
                    </button>
                @endcan
            @endif
        </div>
        @forelse($teams as $team)
            <div class="section-content team">
                <div class="row">
                    <div class="col-md-4 principal">
                        <a href="{{ route_with_subdomain('team_main', ['teamname' => $team->slug]) }}">
                            <div class="logo-back" style="background-image: url('{{ $team->banner }}')"></div>
                            <img class="logo-front" src="{{ $team->avatar }}" alt="">
                            @if($user->id === Auth::id())
                                @if(isset($user->activeTeam) && $team->id === $user->activeTeam->id)
                                    <div class="etoile-active">
                                        <i class="fa fa-star"></i>
                                    </div>
                                @else
                                    <form action="{{ route_with_subdomain('team_select', ['team' => $team]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('post') }}
                                        <div class="etoile-inactive">
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </form>
                                @endif
                            @endif
                            <div class="team-name">{{ $team->name }}</div>
                        </a>
                        @if($user->id === Auth::id())
                            @if(isset($user->activeTeam))
                                <div class="profile-teams-actions-buttons-container">
                                    @if($team->id == $user->activeTeam->id)
                                        <button type="button" class="btn btn-success">
                                            <i class="fa fa-star"></i> @lang('app.front.profile.teams.current-team')
                                        </button>
                                    @else
                                        <form action="{{ route_with_subdomain('team_select', ['team' => $team]) }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('post') }}
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-star-o"></i> @lang('app.front.profile.teams.activate-team')
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="col-md-8">
                        @foreach($team->members as $member)
                            @component('components.gamer')
                                @slot('gamer', $member)
                                @slot('role', $member->pivot->role)
                            @endcomponent
                        @endforeach
                    </div>
                </div>
            </div>
            @unless($loop->last)
                <div class="section-content-separator"></div>
            @endunless
        @empty
            <div class="section-content composition">
                <div class="row">
                    <div class="col-md-12 text-center">
                        @lang('app.front.profile.teams.text-no-teams')
                    </div>
                </div>
            </div>
        @endforelse
    </div>
    
    @if($candidatures->count() > 0)
        <div class="bloc">
            <div class="section-title">
                @lang('app.front.profile.teams.title_candidatures')
            </div>
            @foreach($candidatures as $candidature)
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-4 principal">
                            <a href="{{ route_with_subdomain('team_main', ['teamname' => $candidature->slug]) }}">
                                <div class="logo-back" style="background-image: url('{{ $candidature->banner }}')"></div>
                                <img class="logo-front" src="{{ $candidature->avatar }}" alt="">
                                <div class="team-name">{{ $candidature->name }}</div>
                            </a>
                            @if($user->id === Auth::id())
                                <div class="profile-teams-actions-buttons-container">
                                    <form action="{{ route_with_subdomain('team_members_abortcandidate', ['team' => $candidature]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button type="submit" class="btn btn-warning btn-block">@lang('app.front.team.layout.abort-candidate')</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            @foreach($candidature->members as $member)
                                @component('components.gamer')
                                    @slot('gamer', $member)
                                    @slot('role', $member->pivot->role)
                                @endcomponent
                            @endforeach
                        </div>
                    </div>
                </div>
                @unless($loop->last)
                    <div class="section-content-separator"></div>
                @endunless
            @endforeach
        </div>
    @endif

    @if($invites->count() > 0)
        <div class="bloc">
            <div class="section-title">
                @lang('app.front.profile.teams.title_invites')
            </div>
            @foreach($invites as $invite)
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-4 principal">
                            <a href="{{ route_with_subdomain('team_main', ['teamname' => $invite->slug]) }}">
                                <div class="logo-back" style="background-image: url('{{ $invite->banner }}')"></div>
                                <img class="logo-front" src="{{ $invite->avatar }}" alt="">
                                <div class="team-name">{{ $invite->name }}</div>
                            </a>
                            @if($user->id === Auth::id())
                                <div class="profile-teams-actions-buttons-container">
                                    <form action="{{ route_with_subdomain('team_members_acceptinvite', ['team' => $invite]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('patch') }}
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-fw fa-check"></i>
                                            @lang('app.front.team.layout.accept-invite')
                                        </button>
                                    </form>
                                    <form action="{{ route_with_subdomain('team_members_declineinvite', ['team' => $invite]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-fw fa-times"></i>
                                            @lang('app.front.team.layout.decline-invite')
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            @foreach($invite->members as $member)
                                @component('components.gamer')
                                    @slot('gamer', $member)
                                    @slot('role', $member->pivot->role)
                                @endcomponent
                            @endforeach
                        </div>
                    </div>
                </div>
                @unless($loop->last)
                    <div class="section-content-separator"></div>
                @endunless
            @endforeach
        </div>
    @endif
@endsection

@push('modals')
    @can('update', $user)
        <!-- Create Team Modal -->
        <div class="remodal" data-remodal-id="create-team" role="dialog">
            <div class="row">
                <button data-remodal-action="close" class="remodal-close"></button>
                <div class="row" style="background:white">
                    <h1 class="text-center">
                        @lang('app.front.profile.teams.modals.create-team.title')
                    </h1>
                </div>
                <div class="row text-center" style="padding:10px 0 ;">
                    <img src="/img/logo-notext.png" class="img" width="100" >
                </div>
                <div class="alert alert-danger fade-in" role="alert" style="display: none"></div>
                <form class="form-horizontal" method="post" action="{{ route_with_subdomain('profile_create_team', ['user' => $user]) }}">
                    {{ method_field('POST') }}
                    
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <input type="text" class="form-control" id="team-name" name="team-name" placeholder="" maxlength="15" required>
                                    <p class="help-block">@lang('app.front.profile.teams.modals.create-team.help')</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <button type="submit" class="btn btn-primary btn-block">@lang('app.front.profile.teams.modals.create-team.button')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- / Create Team Modal -->
    @endcan
@endpush

@push('scripts')
    @can('update', $user)
        <!-- JS Create Team Modal -->
        <script>
            (function() {
                // Create Team ModalBox
                var $remodalCreateTeam = $('[data-remodal-id="create-team"]');
                $remodalCreateTeam.on('submit', 'form', function(e) {
                    e.preventDefault();
                    
                    var $this = $(this);
                    
                    var $submitButton = $remodalCreateTeam.find('button[type="submit"]');
                    $submitButton.attr('disabled', 'disabled');
                    
                    addSpinnerTo($submitButton);
                    
                    var $alertsBox = $remodalCreateTeam.find('.alert');
                    $alertsBox.css('display', 'none');
                    
                    $.post($this.attr('action'), $this.serialize())
                        .done(function(data, status, jqXhr) {
                            if (data && data.redirect) {
                                window.location.replace(data.redirect);
                            } else {
                                window.location.reload();
                            }
                        })
                        .fail(function(data) {
                            if (data.responseJSON.error) {
                                $alertsBox.html(data.responseJSON.error);
                            } else if (data.status == 422) {
                                $alertsBox.html(data.responseJSON['team-name']);
                            } else {
                                $alertsBox.html("@lang('app.global.generic-texts.error-occured')");
                            }
                            $alertsBox.css('display', 'block');
                        })
                        .always(function() {
                            $submitButton.attr('disabled', null);
                            removeSpinnerFrom($submitButton);
                        });
                });
            })();
        </script>
        
        <!-- JS Select Team -->
        <script>
            (function () {
                // Active Team
                $('.etoile-inactive').on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var $this = $(this);
                    $this.parent('form').submit();
                });
            })();
        </script>
    @endcan
@endpush
