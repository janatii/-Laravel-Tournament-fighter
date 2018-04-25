@extends('layout')

@section('wrapper')
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">@lang('app.global.generic-texts.toggle-nav')</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ route('admin_home') }}">
                    {{ config('app.name', 'Laravel') }} - @lang('app.admin.title')
                </a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa fa-user"></i> {{ Auth::user()->username }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ route('home', ['subdomain' => 'www']) }}">
                                <i class="fa fa-fw fa-window-maximize"></i> @lang('app.admin.user-menu.front')
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('parameters_main', ['subdomain' => 'www']) }}">
                                <i class="fa fa-fw fa-user"></i> @lang('app.admin.user-menu.parameters')
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-fw fa-power-off"></i> @lang('app.admin.user-menu.logout')
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    @hasanyrole(['superadmin','admin'])
                        <li {!! (Route::currentRouteName() == 'admin_users_list') ? 'class="active"' : '' !!}>
                            <a href="{{ route('admin_users_list') }}"><i class="fa fa-fw fa-users"></i> @lang('app.admin.menu.users')</a>
                        </li>
                        <li {!! (Route::currentRouteName() == 'admin_platforms_list') ? 'class="active"' : '' !!}>
                            <a href="{{ route('admin_platforms_list') }}"><i class="fa fa-fw fa-cubes"></i> @lang('app.admin.menu.platforms')</a>
                        </li>
                        <li {!! (Route::currentRouteName() == 'admin_games_list') ? 'class="active"' : '' !!}>
                            <a href="{{ route('admin_games_list') }}"><i class="fa fa-fw fa-gamepad"></i> @lang('app.admin.menu.games')</a>
                        </li>
                        <li {!! (Route::currentRouteName() == 'admin_networks_list') ? 'class="active"' : '' !!}>
                            <a href="{{ route('admin_networks_list') }}"><i class="fa fa-fw fa-address-card"></i> @lang('app.admin.menu.networks')</a>
                        </li>
                        <li {!! (Route::currentRouteName() == 'admin_pages_list') ? 'class="active"' : '' !!}>
                            <a href="{{ route('admin_pages_list') }}"><i class="fa fa-fw fa-files-o"></i> @lang('app.admin.menu.pages')</a>
                        </li>
                        <li {!! (Route::currentRouteName() == 'admin_wallet_list') ? 'class="active"' : '' !!}>
                            <a href="{{ route('admin_wallet_list') }}"><i class="fa fa-fw fa-files-o"></i> @lang('app.admin.menu.wallet')</a>
                        </li>
                    @endhasanyrole
                    @hasanyrole(['superadmin','admin','referee'])
                        <li {!! (Route::currentRouteName() == 'admin_referee_list') ? 'class="active"' : '' !!}>
                            <a href="{{ route('admin_referee_list') }}"><i class="fa fa-fw fa-files-o"></i> @lang('app.admin.menu.referee')</a>
                        </li>
                    @endhasanyrole
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
    
        <div id="page-wrapper">
    
            <div class="container-fluid" id="app">
                @include('partials.alerts')
                
                @yield('content')
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">
@endpush
