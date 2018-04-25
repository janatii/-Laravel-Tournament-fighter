@extends('front.layout')

@section('content')
    <div class="bancanopy">
        <div class="bancanopy-inner">
            <div class="bancanopy-header">
                <div class="bancanopy-header-bg" id="bannerImg" style="background-image: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.55)), url('{{ Auth::user()->banner }}')">
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                            <li {!! (Route::currentRouteName() == 'parameters_main') ? 'class="active"' : '' !!}>
                                <a role="presentation" href="{{ route_with_subdomain('parameters_main') }}">@lang('app.front.parameters.menu.general')</a>
                            </li>
                            <li {!! (Route::currentRouteName() == 'parameters_email') ? 'class="active"' : '' !!}>
                                <a role="presentation" href="{{ route_with_subdomain('parameters_email') }}">@lang('app.front.parameters.menu.email')</a>
                            </li>
                            <li {!! (Route::currentRouteName() == 'parameters_password') ? 'class="active"' : '' !!}>
                                <a role="presentation" href="{{ route_with_subdomain('parameters_password') }}">@lang('app.front.parameters.menu.password')</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @yield('form_title')
                    </div>

                    <form method="post" @yield('form_attr')>
                        <div class="panel-body">
                            @if(session()->has('errors'))
                                <div class="alert alert-danger" role="alert">
                                    @lang('app.global.generic-texts.errors-occured')
                                </div>
                            @elseif(session()->has('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @elseif(session()->has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            {{ csrf_field() }}

                            @yield('form_content')
                        </div>

                        <div class="panel-footer text-right">
                            @yield('form_buttons')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
