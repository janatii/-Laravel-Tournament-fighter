@extends('front.layout')

@section('content')
    <div class="bancanopy">
        <div class="bancanopy-inner">
            <div class="bancanopy-header">
                <div class="bancanopy-header-bg" id="bannerImg" style="background-image: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.55)), url('{{ $team->banner }}')">
                    <div class="img-change-background"></div>
                    <div class="img-change-text">
                        @lang('app.front.team.layout.click-to-change-banner')
                    </div>
                </div>
                <div class="profilcanopy">
                    <div class="container">
                        <div class="row mid-wrapper">
                            <div class="col-xs-2">
                                <div class="profilcanopy-avatar">
                                    <div class="profil-avatar" id="avatarImg" style="background-image: url('{{ $team->avatar }}')">
                                        <div class="img-change-background"></div>
                                        <div class="img-change-text">
                                            @lang('app.front.team.layout.click-to-change-avatar')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-10">
                                <div class="pseudocanopy-with-classement">
                                    <div class="pseudocanopy">
                                        <div class="pseudo">{{ $team->name }}</div>
                                    </div>
                                    <div class="classement-solo">
                                        <div class="detail">
                                            <div><span class="clsmt-elo">{{ $team->getRank() }}°</span></div>
                                            <div><span class="clsmt-elo">{{ $team->score }} <i class="fa fa-line-chart"></i></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bancanopy-footer">
                <div class="profil-nav">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-8 col-xs-offset-3" style="padding-left: 0">
                                <ul class="navigation">
                                    <li><a {!! (Route::currentRouteName() == 'team_main') ? 'class="active"' : '' !!} href="{{ route_with_subdomain('team_main', ['teamname' => $team->slug]) }}">@lang('app.front.team.layout.menu.home')</a></li>
                                    <li><a {!! (Route::currentRouteName() == 'team_members') ? 'class="active"' : '' !!} href="{{ route_with_subdomain('team_members', ['teamname' => $team->slug]) }}">@lang('app.front.team.layout.menu.members')</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="xs-navigation">
        <div class="container">
            <div class="row navigate">
                <div class="col-sm-2 col-xs-4"><a {!! (Route::currentRouteName() == 'team_main') ? 'class="active"' : '' !!} href="{{ route_with_subdomain('team_main', ['teamname' => $team->slug]) }}">@lang('app.front.team.layout.menu.home')</a></div>
                <div class="col-sm-2 col-xs-4"><a {!! (Route::currentRouteName() == 'team_members') ? 'class="active"' : '' !!} href="{{ route_with_subdomain('team_members', ['teamname' => $team->slug]) }}">@lang('app.front.team.layout.menu.members')</a></div>
            </div>
        </div>
    </div>
    
    <!-- MAIN-CONTENT -->
    <div class="main-content-wrapper">
        <div class="container">
            <div class="row mid-wrapper">
                
                <!--Sidebar-->
                <div class="col-lg-3 middle-sidebar recent-left-sidebar" id="left-sidebar">
                    @if(Auth::check() && Auth::id() != $team->owner_id)
                        @if($team->bans->contains(Auth::id()))
                            <div class="bloc">
                                @lang('app.front.team.layout.you-are-ban')
                            </div>
                        @else
                            @can('leave', $team)
                                <div class="bloc">
                                    <form class="js-confirmable-form" action="{{ route_with_subdomain('team_members_leave', ['team' => $team]) }}" method="post" data-confirm="@lang('app.front.team.layout.sure-to-leave-question', ['name' => $team->name])">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger btn-block">@lang('app.front.team.layout.leave')</button>
                                    </form>
                                </div>
                            @elsecan('accept-invite', $team)
                                <div class="bloc">
                                    <form action="{{ route_with_subdomain('team_members_acceptinvite', ['team' => $team]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('patch') }}
                                        <button type="submit" class="btn btn-success btn-block">
                                            <i class="fa fa-fw fa-check"></i>
                                            @lang('app.front.team.layout.accept-invite')
                                        </button>
                                    </form>
                                </div>
                                <div class="bloc">
                                    <form action="{{ route_with_subdomain('team_members_declineinvite', ['team' => $team]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button type="submit" class="btn btn-danger btn-block">
                                            <i class="fa fa-fw fa-times"></i>
                                            @lang('app.front.team.layout.decline-invite')
                                        </button>
                                    </form>
                                </div>
                            @elsecan('abort-candidate', $team)
                                <div class="bloc">
                                    <form action="{{ route_with_subdomain('team_members_abortcandidate', ['team' => $team]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button type="submit" class="btn btn-warning btn-block">@lang('app.front.team.layout.abort-candidate')</button>
                                    </form>
                                </div>
                            @elsecan('join', $team)
                                <div class="bloc">
                                    <form action="{{ route_with_subdomain('team_members_candidate', ['team' => $team]) }}" method="post">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-success btn-block">@lang('app.front.team.layout.join')</button>
                                    </form>
                                </div>
                            @endcan
                        @endif
                    @endif
                    @can('manage', $team)
                        <div class="bloc">
                            <button id="changeProfileButton" class="btn btn-primary btn-block button"><i class="fa fa-edit"></i> @lang('app.front.team.layout.change')</button>
                        </div>
                    @endcan
                    <div class="bloc about-gamer">
                        <div class="section-content">
                            @if(!empty($team->description))
                                <p>{{ $team->description }}</p>
                            @endif
                            <p>
                                @if(!empty($team->country))
                                    <span class="bfh-countries" data-country="{{ $team->country }}" data-flags="true"></span>
                                @endif
                            </p>
                            <p>
                                <span></span>
                                @if(!empty($team->website))
                                    <a rel="noopener noreferrer" target="_blank" href="{{ $team->website }}">@lang('app.front.team.layout.see-my-website')</a>
                                @endif
                            </p>
                            <div class="social-link">
                                @if(!empty($networks['twitter']['identifier']))
                                    <span><a rel="noopener noreferrer" target="_blank" href="https://twitter.com/{{ urlencode($networks['twitter']['identifier']) }}"><img src="{{ $networks['twitter']['logo'] }}" alt=""></a></span>
                                @endif
                                @if(!empty($networks['facebook']['identifier']))
                                    <span><a rel="noopener noreferrer" target="_blank" href="{{ $networks['facebook']['identifier'] }}"><img src="{{ $networks['facebook']['logo'] }}" alt=""></a></span>
                                @endif
                                @if(!empty($networks['googleplus']['identifier']))
                                    <span><a rel="noopener noreferrer" target="_blank" href="https://plus.google.com/+{{ urlencode($networks['googleplus']['identifier']) }}"><img src="{{ $networks['googleplus']['logo'] }}" alt=""></a></span>
                                @endif
                                @if(!empty($networks['youtube']['identifier']))
                                    <span><a rel="noopener noreferrer" target="_blank" href="{{ $networks['youtube']['identifier'] }}"><img src="{{ $networks['youtube']['logo'] }}" alt=""></a></span>
                                @endif
                                @if(!empty($networks['twitch']['identifier']))
                                    <span><a rel="noopener noreferrer" target="_blank" href="{{ $networks['twitch']['identifier'] }}"><img src="{{ $networks['twitch']['logo'] }}" alt=""></a></span>
                                @endif
                            </div>
                        </div>
                    </div>
    
                    @if(!empty($networks['twitter']['identifier']))
                        <div class="bloc tweets">
                            <a class="twitter-timeline" data-lang="{{ App::getLocale() }}" data-width="238" data-height="300" data-theme="light" href="https://twitter.com/{{ urlencode($networks['twitter']['identifier']) }}">@lang('app.front.team.layout.tweets-by') {{ $networks['twitter']['identifier'] }}</a>
                            <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
                        </div>
                    @endif
                
                </div> <!-- End Sidebar -->

                @can('manage', $team)
                    <!-- isEditing sidebar -->
                    <div class="col-lg-3 middle-sidebar recent-left-sidebar sidebar-is-editing">
                        <form action="{{ route_with_subdomain('team_main_save', ['user' => $team->id]) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            
                            <button type="button" class="btn btn-default" style="border-radius: 2px" id="closeChangeProfileButton">@lang('app.global.generic-texts.abort')</button>
                            <button type="submit" class="btn btn-primary" style="border-radius: 2px" id="saveProfileButton">@lang('app.global.generic-texts.save')</button>

                            <div class="bloc">
                                <div class="section-content">
                                    <div class="{{ $errors->has('name') ? 'has-error' : '' }}">
                                        <input name="name" class="team-name form-control input-sm" placeholder="@lang('app.front.team.layout.name-placeholder')" maxlength="15" value="{{ old('name', $team->name) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="bloc">
                                <div class="section-content">
                                    <div class="{{ $errors->has('description') ? 'has-error' : '' }}">
                                        <textarea name="description" class="team-description form-control input-sm" placeholder="@lang('app.front.team.layout.description-placeholder')" maxlength="200">{{ old('description', $team->description) }}</textarea>
                                    </div>
                                    
                                    <div class="bfh-selectbox bfh-countries input-group-sm {{ $errors->has('country') ? 'has-error' : '' }}" data-name="country" data-country="{{ old('country', $team->country) }}" data-flags="true">
                                    </div>
                                    
                                    <div class="input-group input-group-sm {{ $errors->has('website') ? 'has-error' : '' }}">
                                        <span class="input-group-addon">www</span>
                                        <input type="text" name="website" class="form-control input-sm" placeholder="Website" value="{{ old('website', $team->website) }}" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bloc">
                                <div class="section-content">
                                    <div class="input-group input-group-sm {{ $errors->has('networks.twitter') ? 'has-error' : '' }}">
                                        <span class="input-group-addon">@</span>
                                        <input type="text" name="networks[twitter]" class="form-control input-sm" placeholder="Twitter" value="{{ old('networks.twitter' , $networks['twitter']['identifier'] ?? '') }}" maxlength="15">
                                    </div>
                                    <div class="input-group input-group-sm {{ $errors->has('networks.googleplus') ? 'has-error' : '' }}">
                                        <span class="input-group-addon">+</span>
                                        <input type="text" name="networks[googleplus]" class="form-control input-sm" placeholder="Google+" value="{{ old('networks.googleplus' , $networks['googleplus']['identifier'] ?? '') }}" maxlength="64">
                                    </div>
                                    <div class="input-group input-group-sm {{ $errors->has('networks.facebook') ? 'has-error' : '' }}" >
                                        <span class="input-group-addon">www</span>
                                        <input type="text" name="networks[facebook]" class="form-control input-sm" placeholder="Facebook" value="{{ old('networks.facebook' , $networks['facebook']['identifier'] ?? '') }}" maxlength="255">
                                    </div>
                                    <div class="input-group input-group-sm {{ $errors->has('networks.youtube') ? 'has-error' : '' }}">
                                        <span class="input-group-addon">www</span>
                                        <input type="text" name="networks[youtube]" class="form-control input-sm" placeholder="Youtube" value="{{ old('networks.youtube' , $networks['youtube']['identifier'] ?? '') }}" maxlength="255">
                                    </div>
                                    <div class="input-group input-group-sm {{ $errors->has('networks.twitch') ? 'has-error' : '' }}">
                                        <span class="input-group-addon">www</span>
                                        <input type="text" name="networks[twitch]" class="form-control input-sm" placeholder="Twitch" value="{{ old('networks.twitch' , $networks['twitch']['identifier'] ?? '') }}" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <input type="file" id="avatarImgFile" style="display:none" name="avatar" accept="image/jpeg, image/png">
                            <input type="file" id="bannerImgFile" style="display:none" name="banner" accept="image/jpeg, image/png">
                        </form>
                    </div> <!-- End Sidebar -->
                @endcan
                
                <div class="col-lg-9 middle-main">
                    @yield('sub_content')
                </div>
            
            </div>
        </div>
    </div> <!-- END MAIN-CONTENT -->
    
    @if(session()->has('errors'))
        <!-- errors-modal -->
        <div class="remodal" data-remodal-id="errors" role="dialog">
            <button data-remodal-action="close" class="remodal-close"></button>
            <h1>@lang('app.global.generic-texts.oops')</h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <br>
            <button data-remodal-action="confirm" class="remodal-cancel">@lang('app.global.generic-texts.ok')</button>
        </div>
    @endif
@endsection

@can('manage', $team)
    @push('scripts')
        @if(session()->has('errors'))
            <script>
                (function() {
                    var $remodal = $('[data-remodal-id="errors"]');
                    var $remodalObj = $remodal.remodal();
                    
                    $remodal.on('closed', function() {
                        $('#changeProfileButton').click();
                    });
                    
                    $remodalObj.open();
                })();
            </script>
        @endif
        <script src="/js/profile.js"></script>
    @endpush
@endcan
