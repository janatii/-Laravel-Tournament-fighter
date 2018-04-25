@extends('layout')

@push('metas')
<meta name="content-language" content="{{ App::getLocale() }}"/>
<meta name="description" content="Tournament Fighters est une plateforme dédiée aux compétitions de jeux vidéo. Avec notre système Training combiné à une technique d'évaluation de votre niveau, il vous est désormais possible de créer ou trouver un match d'entraînement équilibré en quelques secondes. De plus, avec notre système “Wager”, il vous est possible de parier sur votre victoire afin de doubler votre cash !"/>
<meta name="subject" content="Site de Compétition de Jeux Vidéo"/>
<meta name="copyright" content="Tournament Fighters Copyright"/>
<meta name="author" content="Tournament Fighters"/>
<meta name="identifier-url" content="https://tournamentfighters.com"/>
<meta name="keywords" content="Tournament Fighters, tournament fighters, tournamentfighters, TournamentFighters, Tournois, Console, PC, ps4, xbox, xbox one, Call of Duty, cod, COD, Overwatch, tournois overwatch, r6s, rainbow 6, LAN, esport, E-sport, Jeux vidéo, Counter Strike, elo, classement, scrims, scrim, bracket, jeux vidéo, esport, e-sport, tournois jeux vidéo, compétition jeux vidéo, TNF, TNFighters, @TNFighters, tournois cashprize, wagers, wager, training, paris esport, argent esport" />
<meta property="og:title" content="Tournament Fighters est une plateforme dédiée aux compétitions de jeux vidéo. Avec notre système Training combiné à une technique d'évaluation de votre niveau, il vous est désormais possible de créer ou trouver un match d'entraînement équilibré en quelques secondes. De plus, avec notre système “Wager”, il vous est possible de parier sur votre victoire afin de doubler votre cash !"/>
<meta property="og:url" content="https://tournamentfighters.com" />
<meta property="og:type" content="website"/>
<meta property="og:locale" content="{{ App::getLocale() }}" />
<meta property="og:locale:alternate" content="fr" />
<meta property="og:locale:alternate" content="en" />
<meta property="og:site_name" content="Tournament Fighters" />
@endpush

@section('wrapper')
    <div id="wrapper">
        <div class="profil-edit-overlay"></div>
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <div class="logo">
                        <a href="{{ route_with_subdomain('home') }}">
                            <img class="logoMin hidden" src="/img/logo-mini.png" alt="">
                            <img class="logoMax" src="/img/logo.png" alt="">
                        </a>
                    </div>
                </li>
                <li id="search-li" class="collapse-hidden">
                    <div class="left-inner-addon">
                        <i class="fa fa-search"></i>
                        <input type="text" name="search" id="searchInput" placeholder="@lang('app.front.search.input-placeholder')">
                    </div>
                </li>
                <li>
                    <a href="{{ route_with_subdomain('trainings_main') }}" @if(!isset($game_selected))class="js-no-game-selected"@endif>
                        <i class="fa fa-fw fa-line-chart"></i>
                        <span class="collapse-hidden">
                            @lang('app.front.main-menu.trainings')
                        </span>
                    </a>
                </li>
                @if(Auth::check())
                    <li>
                        <a href="{{ route_with_subdomain('profile_main', ['pseudo' => Auth::user()->username]) }}" @if(!isset($game_selected))class="js-no-game-selected"@endif>
                            <i class="fa fa-fw fa-user"></i>
                            <span class="collapse-hidden">@lang('app.front.main-menu.my-profile')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route_with_subdomain('profile_teams', ['pseudo' => Auth::user()->username]) }}" @if(!isset($game_selected))class="js-no-game-selected"@endif>
                            <i class="fa fa-fw fa-users"></i>
                            <span class="collapse-hidden">@lang('app.front.main-menu.my-teams')</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route_with_subdomain('shop_main') }}">
                        <i class="fa fa-fw fa-shopping-cart"></i>
                        <span class="collapse-hidden">@lang('app.front.main-menu.shop')</span>
                    </a>
                </li>
            </ul>
            @if(Auth::check() && isset($game_selected, $active_team) && $game_selected->id === $active_team->game_id)
                <a href="{{ route_with_subdomain('team_main', ['name' => $active_team->name]) }}">
                    <div class="teamlist-title" style="background-image: url('{{ $active_team->banner }}')">
                        <img class="teamlist-logo" src="{{ $active_team->avatar }}" alt="">
                        <div class="teamlist-name">
                            <div>{{ $active_team->name }}</div>
                        </div>
                    </div>
                </a>
                <ul class="teamlist-members">
                    @foreach($active_team->members as $member)
                        <li class="teamlist-member js-teamlist-member-{{ $member->id }} {{ $member->isPremium() ? 'premium' : '' }}">
                            <a href="{{ route_with_subdomain('profile_main', ['pseudo' => $member->username]) }}">
                                <div class="online-indicator">&nbsp;</div>
                                <div class="avatar">
                                    <img src="{{ $member->avatar }}" alt="">
                                </div>
                                <div class="content">
                                    <div class="name">{{ $member->username }}</div>
                                    <div class="state">@lang('app.global.generic-texts.offline')</div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
            
            <ul class="sidebar-nav sidebar-nav-pages">
                @foreach($menu_pages as $menu_page)
                    <li>
                        <a href="{{ $menu_page->url }}"><span class="collapse-hidden">{{ $menu_page->title }}</span></a>
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">
            
            <!-- TOP MENU -->
            <nav class="menu-top navbar navbar-default navbar-fixed-top">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">@lang('app.global.generic-texts.toggle-nav')</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="#menu-toggle" id="menu-toggle" class="navbar-brand"><i class="fa fa-caret-left"></i></a>
                        <div class="menu-gameicon navbar-brand text-center" id="game-logo">
                            @if(isset($game_selected))
                                <img src="{{ $game_selected->logo }}" alt="{{ $game_selected->name }} @lang('app.global.generic-texts.logo')">
                            @else
                                <img src="{{ asset(config("uploads.public_path") . 'games/logo/default') }}" alt="@lang('app.front.main-menu.no-game-selected')">
                            @endif
                            <i class="fa fa-chevron-down visible-xs"></i>
                        </div>
                    </div>
                    
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navleft hidden-xs">
                            <li class="dropdown dropdown-first" id="js-select-game-dropdown">
                                <a href="#" class="dropdown-toggle navleft-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    @lang('app.front.main-menu.select-your-game') <i class="fa fa-chevron-down chevron-down"></i>
                                </a>
                                <div class="dropdown-menu list-game-choice">
                                    <div class="container game-list-wrapper">
                                        @foreach($menu_games as $menu_plaform)
                                            <div class="row">
                                                <div class="col-xs-12 header"><img src="{{ $menu_plaform->logo }}" alt="{{ $menu_plaform->name }} @lang('app.global.generic-texts.logo')"></div>
                                            </div>
                                            <div class="row game-wrapper">
                                                @foreach($menu_plaform->games as $menu_game)
                                                    @if($menu_game->published)
                                                        <div class="col-xs-6 game-item"><a href="{{ route('trainings_main', ['subdomain' => $menu_game->subdomain]) }}"><img src="{{ $menu_game->menu_logo }}" alt="{{ $menu_game->name }} @lang('app.global.generic-texts.logo')"></a></div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                        </ul>
                        
                        <ul class="nav navbar-nav navbar-right {{ Auth::check() ? 'navright' : 'notconnected-nav' }}">
                            <clock locale="{{ App::getLocale() }}"></clock>
                            
                            @if(Auth::check())
                                <li data-toggle="tooltip" data-placement="bottom" title="Gains">
                                    <a href="{{ route_with_subdomain('shop_credits') }}">
                                        <div class="navright-square-1">
                                            @if(Auth::user()->credits > 0)
                                                {{ Auth::user()->credits }}
                                            @else
                                                @lang('app.front.user-menu.deposit-money')
                                            @endif
                                            <img src="/img/level-icon-1.png" alt="">
                                        </div>
                                    </a>
                                </li>
    
                                @if(isset($game_selected))
                                    <li data-toggle="tooltip" data-placement="bottom" title="@lang('app.front.user-menu.elo-ranking')">
                                        <a href="#/profil.stats">
                                            <div class="navright-square-2">
                                                {{ Auth::user()->getScore($game_selected) }} <i class="fa fa-line-chart"></i>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                    
                                @if(isset($match_in_progress))
                                    <li data-toggle="tooltip" data-placement="bottom" title="{{ $match_in_progress->isWaitingConfirmation() ? trans('app.front.user-menu.match-wait-confirm') : trans('app.front.user-menu.match-in-progress') }}">
                                        <a href="{{ route('training_show', ['subdomain' => $match_in_progress->game->subdomain, 'match' => $match_in_progress]) }}">
                                            <div class="navright-circle {{ $match_in_progress->isWager() ? 'navright-circle-wager' : '' }}">
                                                <i class="fa fa-gamepad"></i>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                    
                                @if(isset($game_selected))
                                    @if(count($game_teams) > 0)
                                        <li class="dropdown dropdown-menu-team" data-toggle="tooltip" data-placement="bottom" title="@lang('app.front.user-menu.change-active-team')">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <div class="navright-circle"><i class="fa fa-group"></i></div>
                                            </a>
                                            <ul class="dropdown-menu team-menu">
                                                @foreach($game_teams as $team)
                                                    <li>
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-xs-3">
                                                                    <div class="teamlogo">
                                                                        <img src="{{ $team->avatar }}" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-7">
                                                                    <div class="teamdetails">
                                                                        <div class="teamname">
                                                                            {{ $team->name }}
                                                                        </div>
                                                                        <div class="teamclass">
                                                                            {{ $team->score }} <i class="fa fa-line-chart"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-2">
                                                                    <div class="text-center teamstate">
                                                                        @if(isset($active_team) && $team->id === $active_team->id)
                                                                            <i class="fa fa-check"></i>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form action="{{ route_with_subdomain('team_select', ['team' => $team]) }}" method="post">
                                                            {{ csrf_field() }}
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                @endif
                                
                                <li class="dropdown" title="@lang('app.front.user-menu.notifications')">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <div class="navright-circle">
                                            <i class="fa fa-bell"></i><span id="notifications-counter" class="nb-notif" @if(Auth::user()->unreadNotifications->count() == 0)style="display: none"@endif>{{ Auth::user()->unreadNotifications->count() }}</span>
                                        </div>
                                    </a>
                                    <ul class="@if(Auth::user()->unreadNotifications->count() > 0) dropdown-menu @endif player-notifications">
                                        @foreach(Auth::user()->unreadNotifications as $notification)
                                            <li>
                                                <button data-uri="{{ route('notifications_deleteone', ['notifid' => $notification->id]) }}" type="submit" class="player-notif-read-btn"><i class="fa fa-times"></i></button>
                                                <div class="player-notif-title">
                                                    {{ $notification->data['title'] }}
                                                </div>
                                                <div class="player-notif-text">
                                                    {{ $notification->data['text'] }}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle hidden-xs" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <div class="navright-pseudo">
                                            <div class="menu-pseudo {{ Auth::user()->isPremium() ? 'premium' : '' }}">
                                                <span class="username">{{ Auth::user()->username }}</span>
                                                <span class="caret"></span>
                                            </div>
                                            <div class="menu-avatar">
                                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->username }} @lang('app.global.generic-texts.avatar')" title="{{ Auth::user()->username }}">
                                            </div>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu player-menu">
                                        <li>
                                            <a href="{{ route_with_subdomain('profile_main', ['pseudo' => Auth::user()->username]) }}" @if(!isset($game_selected))class="js-no-game-selected"@endif>
                                                <i class="fa fa-fw fa-user player-menu-fa-blue"></i> @lang('app.front.user-menu.my-profile')
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route_with_subdomain('profile_teams', ['pseudo' => Auth::user()->username]) }}" @if(!isset($game_selected))class="js-no-game-selected"@endif>
                                                <i class="fa fa-fw fa-group player-menu-fa-blue"></i> @lang('app.front.user-menu.my-teams')
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route_with_subdomain('wallet_main') }}">
                                                <i class="fa fa-fw fa-money player-menu-fa-blue"></i> @lang('app.front.user-menu.my-safe')
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route_with_subdomain('parameters_main') }}">
                                                <i class="fa fa-fw fa-cog player-menu-fa-blue"></i> @lang('app.front.user-menu.parameters')
                                            </a>
                                        </li>
                                        @unless(Auth::user()->isPremium())
                                            <li>
                                                <a href="{{ route_with_subdomain('shop_premium') }}" class="premium">
                                                    <img class="premium-icon" src="/img/premium-icon.png" alt=""> @lang('app.front.user-menu.become-premium')
                                                </a>
                                            </li>
                                        @endunless
                                        <li>
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fa fa-fw fa-sign-out player-menu-fa-red"></i> @lang('app.front.user-menu.logout')
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="player-menu visible-xs">
                                        <li>
                                            <a href="{{ route_with_subdomain('profile_main', ['pseudo' => Auth::user()->username]) }}">
                                                <i class="fa fa-fw fa-cog player-menu-fa-blue"></i> @lang('app.front.user-menu.my-profile')
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route_with_subdomain('profile_teams', ['pseudo' => Auth::user()->username]) }}" @if(!isset($game_selected))class="js-no-game-selected"@endif>
                                                <i class="fa fa-fw fa-group player-menu-fa-blue"></i> @lang('app.front.user-menu.my-teams')
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-fw fa-money player-menu-fa-blue"></i> @lang('app.front.user-menu.my-safe')
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route_with_subdomain('parameters_main') }}">
                                                <i class="fa fa-fw fa-cog player-menu-fa-blue"></i> @lang('app.front.user-menu.parameters')
                                            </a>
                                        </li>
                                        @unless(Auth::user()->isPremium())
                                            <li>
                                                <a href="{{ route_with_subdomain('shop_premium') }}" class="premium">
                                                    <img class="premium-icon" src="/img/premium-icon.png" alt=""> @lang('app.front.user-menu.become-premium')
                                                </a>
                                            </li>
                                        @endunless
                                        <li>
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fa fa-fw fa-sign-out player-menu-fa-red"></i> @lang('app.front.user-menu.logout')
                                            </a>
                                        </li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="post" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            @else
                                <li><a class="btn btn-default" data-remodal-target="inscription">@lang('app.front.user-menu.register') <i class="fa fa-book"></i></a></li>
                                <li><a class="btn btn-default" data-remodal-target="login">@lang('app.front.user-menu.login') <i class="fa fa-user"></i></a></li>
                            @endif
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
            
            @yield('content')
            
            @if(Auth::guest())
                <!-- signup-modal -->
                <div class="remodal" data-remodal-id="inscription" role="dialog">
                    <button data-remodal-action="close" class="remodal-close"></button>
                    
                    <h1>
                        @lang('app.front.register.title')<br>
                        <small>@lang('app.front.register.subtitle')</small>
                    </h1>
                    
                    <img src="/img/logo.png" class="img" width="100">
                    
                    <hr>
                    
                    <div class="alert alert-danger fade-in" role="alert" style="display: none"></div>
    
                    <div class="row">
                        <div class="col-sm-11">
                            <form class="form-horizontal" action="{{ route('register') }}" method="post">
                                {{ csrf_field() }}
                        
                                <div class="form-group">
                                    <label for="pseudo" class="col-sm-4 control-label">@lang('app.global.forms-fields.username')</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="username" placeholder="" name="username" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email" class="col-sm-4 control-label">@lang('app.global.forms-fields.email')</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" id="email" placeholder="" name="email" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="pass" class="col-sm-4 control-label">@lang('app.global.forms-fields.password')</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="password" placeholder="" name="password" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="pass-confirm" class="col-sm-4 control-label">@lang('app.global.forms-fields.repeat-password')</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="password_confirmation" placeholder="" name="password_confirmation" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-4">
                                        {!! Recaptcha::render() !!}
                                    </div>
                                </div>
                        
                                <div class="pull-right">
                                    <button type="button" data-remodal-action="cancel" class="remodal-cancel">@lang('app.global.generic-texts.abort')</button>
                                    <button type="submit" class="remodal-confirm">@lang('app.front.register.sign-up')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.signup-modal -->
                
                <!-- login-modal -->
                <div class="remodal remodal-style-login" data-remodal-id="login" role="dialog">
                    <button data-remodal-action="close" class="remodal-close"></button>
                    
                    <h1>
                        @lang('app.front.login.title')
                    </h1>
                    
                    <img src="/img/logo.png" class="img" width="100">
                    
                    <div class="alert alert-danger fade-in" role="alert" style="display: none"></div>
    
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-1">
                            <form class="form-horizontal" action="{{ route('login') }}" method="post">
                                {{ csrf_field() }}
                                
                                <div class="form-group">
                                    <label for="login" class="col-sm-4 control-label">@lang('app.global.forms-fields.username')</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="pass" class="col-sm-4 control-label">@lang('app.global.forms-fields.password')</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input name="remember" type="checkbox"> @lang('app.auth.remember-me')
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-4">
                                        <button type="submit" class="btn btn-primary btn-block"> @lang('app.front.login.login')</button>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-4">
                                        <a href="{{ route('password.request') }}">@lang('app.auth.forgot-password')</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
    
            <div class="remodal" data-remodal-id="search" role="dialog" data-remodal-options="hashTracking: false">
                <div class="row">
                    <button data-remodal-action="close" class="remodal-close"></button>
                    <div id="searchContainer"></div>
                </div>
            </div>
            
            @stack('modals')
            
        </div>
        <!-- /#page-content-wrapper -->
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
@endpush

@push('vue-data')
    <script>
        Vue.prototype.$trans['generic-texts'] = {!! json_encode(trans('app.global.generic-texts')) !!};
        Vue.prototype.$store.authUser = {!! (new \App\Helpers\Jsonizers\UserJsonizer)->format(Auth::user(), $game_selected ?? null) !!};
        Vue.prototype.$store.gameSelected = {!! (new \App\Helpers\Jsonizers\GameJsonizer)->format($game_selected ?? null) !!};
        Vue.prototype.$store.availableBets = {!! json_encode(config('app.available_bets')) !!};
    </script>
@endpush

@push('head_scripts')
    @if(env('APP_ENV') == 'production')
        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        
        ga('create', 'UA-103159074-1', 'auto');
        ga('send', 'pageview');
        
        </script>
    @endif
@endpush

@push('scripts')
    @if(Auth::check())
        <!-- JS Events -->
        <script>
            (function () {
                Echo.private('user.{{ Auth::id() }}')
                    .listen('MatchRedirect', (e) => {
                        window.location.replace(e.url);
                    });
            })();
        </script>
        @isset($active_team)
            <!-- JS Online Indicators -->
            <script>
                (function () {
                    function updateOnlineIndicator(userId, connected)
                    {
                        var $indicator = $('.js-teamlist-member-' + userId + ' .online-indicator');
                        var $state = $('.js-teamlist-member-' + userId + ' .state');
                        if (connected) {
                            $indicator.addClass('online');
                            $state.text("@lang('app.global.generic-texts.online')");
                        } else {
                            $indicator.removeClass('online');
                            $state.text("@lang('app.global.generic-texts.offline')");
                        }
                        
                        var $connecteds = $('.online-indicator.online').parents('.teamlist-member');
                        $connecteds.sort(function(a, b) {
                            return $(a).find('.name').text() > $(b).find('.name').text();
                        });
                        $('.teamlist-members').prepend($connecteds);
                    }
                    
                    var usersConnected = [];
                    Echo.join('team.{{ $active_team->id }}')
                        .here((users) => {
                            usersConnected = users;
                            usersConnected.forEach(function(user) {
                                updateOnlineIndicator(user.id, true);
                            });
                        })
                        .joining((user) => {
                            usersConnected.push(user);
                            updateOnlineIndicator(user.id, true);
                        })
                        .leaving((user) => {
                            usersConnected = usersConnected.filter(function(item) {
                                return item.id !== user.id;
                            });
                            setTimeout(function() {
                                var userIndex = usersConnected.findIndex(function(item) {
                                    return item.id === user.id;
                                });
                                if (userIndex === -1) {
                                    updateOnlineIndicator(user.id, false);
                                }
                            }, 3000);
                        });
                })();
            </script>
        @endisset
    @else
        <!-- JS Login/Register -->
        <script>
            (function() {
                // Login Modal
                
                remodalize('login');

                // Register Modal
                
                var fail = function(data, $alertsBox) {
                    grecaptcha.reset();
                };
                
                remodalize('inscription', null, fail, fail);
            })();
        </script>
    @endif
    <!-- JS Menus -->
    <script>
        (function () {
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
                $(".navbar-fixed-top").toggleClass("toggled");
                $("i", this).toggleClass(" fa-caret-right fa-caret-left ");
                $(".logo img.logoMin").toggleClass("hidden");
                $(".logo img.logoMax").toggleClass("hidden");
            });

            $(".navleft-item").click(function(e) {
                e.preventDefault();
                $(".dropdown-first").toggleClass("dropdown-first-open");
                $("i", this).toggleClass("fa-chevron-down fa-chevron-up");
                $("i", this).toggleClass("chevron-down chevron-up");
            });
            $(document).click(function() {
                if($(".dropdown-first-open")) {
                    $(".dropdown-first-open").removeClass("dropdown-first-open").addClass("dropdown-first");
                    $(".navleft-item i").removeClass("fa-chevron-up").addClass("fa-chevron-down");
                    if( $(".navleft-item i.chevron-up") ) {
                        $(".navleft-item i.chevron-up").removeClass("chevron-up").addClass("chevron-down");
                    }
                }
            });

            $('.dropdown').on('show.bs.dropdown', function(e){
                $(this).find('.dropdown-menu').first().stop(true, true).slideDown(300);
            });
            $('.dropdown').on('hide.bs.dropdown', function(e){
                $(this).find('.dropdown-menu').first().stop(true, true).slideUp(300);
            });

            $("#game-logo").click(function () {
                var isVisible = $(".game-choice").is(":visible");
                var isHidden = $(".game-choice").is(":hidden");
                if( isHidden ) {
                    $(".game-choice").slideDown(300);
                    $("i", this).toggleClass(" fa-chevron-down fa-chevron-up ");
                }
                if( isVisible ) {
                    $(".game-choice").slideUp(00);
                    var chevronUp = $("i", "#game-logo").hasClass("fa-chevron-up");
                    if (chevronUp) {
                        $("i", "#game-logo").toggleClass(" fa-chevron-down fa-chevron-up ");
                    }
                }
            });

            $(document).mouseup(function (e)
            {
                var container = $(".game-choice");

                if (!container.is(e.target))
                {
                    var chevronUp = $("i", "#game-logo").hasClass("fa-chevron-up");
                    if (chevronUp) {
                        $("i", "#game-logo").toggleClass(" fa-chevron-down fa-chevron-up ");
                    }
                    container.slideUp();
                }
            });

            $(".left-inner-addon input")
                .focusin(function() {
                    $(".left-inner-addon i").fadeTo(300, 0.5);
                })
                .focusout(function() {
                    $(".left-inner-addon i").fadeTo(300, 1);
                });

        })();
    </script>
    <!-- JS Notifications -->
    <script>
        (function () {
            var $counter = $('#notifications-counter');
            var $playerNotifications = $('.player-notifications');

            $('.player-notif-read-btn').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                var $this = $(this);
                $.ajax({
                    url: $this.data('uri'),
                    method: 'DELETE'
                }).done(function(result) {
                    $this.parent('li').slideUp();
                    var counterValue = parseInt($counter.text()) - 1;
                    $counter.text(counterValue);
                    if (counterValue === 0) {
                        $counter.css('display', 'none');
                        $playerNotifications.css('display', 'none');
                        $playerNotifications.removeClass('dropdown-menu');
                    }
                });
            });
        })();
    </script>
    <!-- JS Search -->
    <script>
        (function () {
            var $remodalSearch = $('[data-remodal-id="search"]').remodal();
            $remodalSearch.settings.hashTracking = false;
            
            var searchFunc = debounce(function () {
                var searchValue = $('#searchInput').val();
                if (searchValue.trim() != '') {
                    $.post('{{ route_with_subdomain('search') }}', {
                        'search': searchValue,
                        '_token': '{{ csrf_token() }}'
                    })
                    .done(function (data) {
                        $('#searchContainer').html(data);
                        $remodalSearch.open();
                    })
                    .fail(function (data) {
                        $remodalSearch.close();
                    });
                }
            }, 500);
            
            $('#searchInput').on('keyup', function (e) {
                e.preventDefault();
                
                @if(!isset($game_selected))
                    $('#js-select-game-dropdown:not(.open) .dropdown-toggle').click();
                @else
                    searchFunc();
                @endif
            });
        })();
    </script>
    
    <!-- JS Select Team -->
    <script>
        (function () {
            // Active Team
            $('.dropdown-menu-team li').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var $this = $(this);
                $this.find('form').submit();
            });
        })();
    </script>
@endpush
