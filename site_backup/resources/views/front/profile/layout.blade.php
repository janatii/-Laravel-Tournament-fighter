@extends('front.layout')

@section('content')
    <div class="bancanopy">
        <div class="bancanopy-inner">
            <div class="bancanopy-header">
                <div class="bancanopy-header-bg" id="bannerImg" style="background-image: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.55)), url('{{ $user->banner }}')">
                    <div class="img-change-background"></div>
                    <div class="img-change-text">
                        @lang('app.front.profile.layout.click-to-change-banner')
                    </div>
                </div>
                <div class="profilcanopy">
                    <div class="container">
                        <div class="row mid-wrapper">
                            <div class="col-xs-2">
                                <div class="profilcanopy-avatar">
                                    <div class="profil-avatar" id="avatarImg" style="background-image: url('{{ $user->avatar }}')">
                                        <div class="img-change-background"></div>
                                        <div class="img-change-text">
                                            @lang('app.front.profile.layout.click-to-change-avatar')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-10">
                                <div class="pseudocanopy-with-classement">
                                    <div class="pseudocanopy">
                                        <div class="pseudo {{ $user->isPremium() ? 'premium' : '' }}">
                                            {{ $user->username }} @if($user->isPremium())<img class="premium-icon" src="/img/premium-icon-clear.png" alt="">@endif
                                        </div>
                                    </div>
                                    <div class="classement-solo">
                                        <div class="detail">
                                            <div><span class="clsmt-elo">{{ $user->getRank($game_selected) }}°</span></div>
                                            <div><span class="clsmt-elo">{{ $score }} <i class="fa fa-line-chart"></i></span></div>
                                        </div>
                                    </div>
                                    @if($user->activeTeam)
                                        <a href="{{ route('team_main', ['subdomain' => $user->activeTeam->game->subdomain, 'teamname' => $user->activeTeam->slug]) }}">
                                            <div class="classement-team">
                                                <div class="detail">
                                                    <div>{{ $user->activeTeam->score }} <i class="fa fa-line-chart"></i></div>
                                                    <div>{{ $user->activeTeam->name }}</div>
                                                </div>
                                                <div class="team-logo">
                                                    <img src="{{ $user->activeTeam->avatar }}" alt="">
                                                </div>
                                            </div>
                                        </a>
                                    @endif
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
                                    <li><a {!! (Route::currentRouteName() == 'profile_main') ? 'class="active"' : '' !!} href="{{ route_with_subdomain('profile_main', ['pseudo' => $user->username]) }}">@lang('app.front.profile.layout.menu.home')</a></li>
                                    <li><a {!! (Route::currentRouteName() == 'profile_teams') ? 'class="active"' : '' !!} href="{{ route_with_subdomain('profile_teams', ['pseudo' => $user->username]) }}">@lang('app.front.profile.layout.menu.teams')</a></li>
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
                <div class="col-sm-2 col-xs-4"><a {!! (Route::currentRouteName() == 'profile_main') ? 'class="active"' : '' !!} href="{{ route_with_subdomain('profile_main', ['pseudo' => $user->username]) }}">@lang('app.front.profile.layout.menu.home')</a></div>
                <div class="col-sm-2 col-xs-4"><a {!! (Route::currentRouteName() == 'profile_teams') ? 'class="active"' : '' !!} href="{{ route_with_subdomain('profile_teams', ['pseudo' => $user->username]) }}">@lang('app.front.profile.layout.menu.teams')</a></div>
            </div>
        </div>
    </div>
    
    <!-- MAIN-CONTENT -->
    <div class="main-content-wrapper">
        <div class="container">
            <div class="row mid-wrapper">
                
                <!--Sidebar-->
                <div class="col-lg-3 middle-sidebar recent-left-sidebar" id="left-sidebar">
                    @if(Auth::check() && isset($active_team) && Auth::user()->can('manage', $active_team) && Auth::id() != $user->id && $user->can('be-accepted', $active_team))
                        @if($active_team->candidates->contains($user))
                            <div class="bloc">
                                <form action="{{ route_with_subdomain('team_members_acceptcandidate', ['team' => $active_team, 'user' => $user]) }}" method="post">
                                    {{ csrf_field() }}
                                    <button class="btn btn-success btn-block" type="submit">
                                        <i class="fa fa-user-plus"></i>
                                        @lang('app.front.profile.layout.accept-candidate')
                                    </button>
                                </form>
                            </div>
                            <div class="bloc">
                                <form action="{{ route_with_subdomain('team_members_denycandidate', ['team' => $active_team, 'user' => $user]) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button class="btn btn-danger btn-block" type="submit">
                                        <i class="fa fa-times"></i>
                                        @lang('app.front.profile.layout.deny-candidate')
                                    </button>
                                </form>
                            </div>
                        @elseif(Auth::user()->can('invite-players', $active_team) && $user->can('be-invited', $active_team))
                            <div class="bloc">
                                <form class="form-horizontal" method="post" action="{{ route_with_subdomain('team_members_addinvite_by_id', ['team' => $active_team, 'user' => $user]) }}">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-success btn-block">
                                        @lang('app.front.profile.layout.invite-player')
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endif
                    @can('update', $user)
                        <div class="bloc">
                            <button id="changeProfileButton" class="btn btn-primary btn-block button"><i class="fa fa-edit"></i> @lang('app.front.profile.layout.change')</button>
                        </div>
                    @endcan
                    @if(!empty($networks['playstation']['identifier'])
                     || !empty($networks['xbox']['identifier'])
                     || !empty($networks['steam']['identifier'])
                     || !empty($networks['battletag']['identifier'])
                     || !empty($networks['uplay']['identifier']))
                        <div class="bloc network-ids">
                            @if(!empty($networks['playstation']['identifier']))
                                <div class="section-content">
                                    <span><img src="{{ $networks['playstation']['logo'] }}" alt="Logo PSN"> {{ $networks['playstation']['identifier'] }}</span>
                                </div>
                            @endif
                            @if(!empty($networks['xbox']['identifier']))
                                <div class="section-content">
                                    <span><img src="{{ $networks['xbox']['logo'] }}" alt="Logo Xbox Live"> {{ $networks['xbox']['identifier'] }}</span>
                                </div>
                            @endif
                            @if(!empty($networks['steam']['identifier']))
                                <div class="section-content">
                                    <span><img src="{{ $networks['steam']['logo'] }}" alt="Logo Steam"> {{ $networks['steam']['identifier'] }} </span>
                                </div>
                            @endif
                            @if(!empty($networks['battletag']['identifier']))
                                <div class="section-content">
                                    <span><img src="{{ $networks['battletag']['logo'] }}" alt="Logo BattleTag"> {{ $networks['battletag']['identifier'] }} </span>
                                </div>
                            @endif
                            @if(!empty($networks['uplay']['identifier']))
                                <div class="section-content">
                                    <span><img src="{{ $networks['uplay']['logo'] }}" alt="Logo UPlay"> {{ $networks['uplay']['identifier'] }} </span>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="bloc about-gamer">
                        <div class="section-content">
                            <p>
                                <i class="fa fa-fw fa-calendar"></i> @lang('app.front.profile.layout.member-since') {{ $user->created_at->format(LocalizationFormats::getFormat('date')) }}
                            </p>
                            @if($user->gender == 'm')
                                <p>
                                    <i class="fa fa-fw fa-mars"></i> @lang('app.global.generic-texts.male-funny') -
                                    @if(!empty($user->birthdate))
                                        {{ \Carbon\Carbon::now()->diffInYears($user->birthdate) }} @lang('app.front.profile.layout.years-old')
                                    @endif
                                </p>
                            @elseif($user->gender == 'f')
                                <p>
                                    <i class="fa fa-fw fa-venus"></i> @lang('app.global.generic-texts.female-funny') -
                                    @if(!empty($user->birthdate))
                                        {{ \Carbon\Carbon::now()->diffInYears($user->birthdate) }} @lang('app.front.profile.layout.years-old')
                                    @endif
                                </p>
                            @endif
                            <p>
                                @if(!empty($user->country))
                                    <span class="bfh-countries" data-country="{{ $user->country }}" data-flags="true"></span>
                                @endif
                            </p>
                            <p>
                                <span></span>
                                @if(!empty($user->website))
                                    <a rel="noopener noreferrer" target="_blank" href="{{ $user->website }}">@lang('app.front.profile.layout.see-my-website')</a>
                                @endif
                            </p>
                            @if(!empty($user->description))
                                <p>{{ $user->description }}</p>
                            @endif
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
                            <a class="twitter-timeline" data-lang="{{ App::getLocale() }}" data-width="238" data-height="300" data-theme="light" href="https://twitter.com/{{ urlencode($networks['twitter']['identifier']) }}">@lang('app.front.profile.layout.tweets-by') {{ $networks['twitter']['identifier'] }}</a>
                            <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
                        </div>
                    @endif
                
                </div> <!-- End Sidebar -->

                @can('update', $user)
                    <!-- isEditing sidebar -->
                    <div class="col-lg-3 middle-sidebar recent-left-sidebar sidebar-is-editing">
                        <form action="{{ route_with_subdomain('profile_main_save', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            
                            <button type="button" class="btn btn-default" style="border-radius: 2px" id="closeChangeProfileButton">@lang('app.global.generic-texts.abort')</button>
                            <button type="submit" class="btn btn-primary" style="border-radius: 2px" id="saveProfileButton">@lang('app.global.generic-texts.save')</button>
    
                            <div class="bloc">
                                <div class="section-content">
                                    <div class="{{ $errors->has('networks.playstation') ? 'has-error' : '' }}">
                                        <input type="text" name="networks[playstation]" class="form-control input-sm" placeholder="PSN ID" value="{{ old('networks.playstation' , $networks['playstation']['identifier'] ?? '') }}" maxlength="15">
                                    </div>
                                    <div class="{{ $errors->has('networks.xbox') ? 'has-error' : '' }}">
                                        <input type="text" name="networks[xbox]" class="form-control input-sm" placeholder="Xbox Live ID" value="{{ old('networks.xbox' , $networks['xbox']['identifier'] ?? '') }}" maxlength="15">
                                    </div>
                                    <div class="{{ $errors->has('networks.steam') ? 'has-error' : '' }}">
                                        <input type="text" name="networks[steam]" class="form-control input-sm" placeholder="Steam ID" value="{{ old('networks.steam' , $networks['steam']['identifier'] ?? '') }}" maxlength="15">
                                    </div>
                                    <div class="{{ $errors->has('networks.battletag') ? 'has-error' : '' }}">
                                        <input type="text" name="networks[battletag]" class="form-control input-sm" placeholder="BattleTag" value="{{ old('networks.battletag' , $networks['battletag']['identifier'] ?? '') }}" maxlength="15">
                                    </div>
                                    <div class="{{ $errors->has('networks.uplay') ? 'has-error' : '' }}">
                                        <input type="text" name="networks[uplay]" class="form-control input-sm" placeholder="Uplay ID" value="{{ old('networks.uplay' , $networks['uplay']['identifier'] ?? '') }}" maxlength="15">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bloc">
                                <div class="section-content">
                                    <div class="{{ $errors->has('description') ? 'has-error' : '' }}">
                                        <textarea name="description" class="profile-description form-control input-sm" placeholder="@lang('app.front.profile.layout.description-placeholder')" maxlength="200">{{ old('description', $user->description) }}</textarea>
                                    </div>
    
                                    <div class="{{ $errors->has('gender') ? 'has-error' : '' }}">
                                        <select name="gender" class="form-control input-sm">
                                            <option value="">@lang('app.global.forms-fields.gender')</option>
                                            <option value="m" {{ old('gender', $user->gender) == 'm' ? 'selected' : '' }}>@lang('app.global.generic-texts.male-funny')</option>
                                            <option value="f" {{ old('gender', $user->gender) == 'f' ? 'selected' : '' }}>@lang('app.global.generic-texts.female-funny')</option>
                                        </select>
                                    </div>
                                    
                                    <div class="bfh-selectbox bfh-countries {{ $errors->has('country') ? 'has-error' : '' }}" data-name="country" data-country="{{ old('country', $user->country) }}" data-flags="true" data-blank="false">
                                    </div>
                                    
                                    <div class="input-group input-group-sm {{ $errors->has('website') ? 'has-error' : '' }}">
                                        <span class="input-group-addon">www</span>
                                        <input type="text" name="website" class="form-control input-sm" placeholder="Website" value="{{ old('website', $user->website) }}" maxlength="255">
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

@can('update', $user)
    @push('styles')
        <link rel="stylesheet" href="/vendor/bootstrap-formhelpers/css/bootstrap-formhelpers.min.css">
    @endpush
    
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
        <script src="/vendor/bootstrap-formhelpers/js/bootstrap-formhelpers.min.js"></script>
        <script src="/js/profile.js"></script>
    @endpush
@endcan