@extends('front.layout')

@section('content')
    <div class="container shop">
        <div class="row">
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                            <li {!! (Route::currentRouteName() == 'shop_premium') ? 'class="active"' : '' !!}>
                                <a role="presentation" href="{{ route_with_subdomain('shop_premium') }}">@lang('app.front.shop.menu.premium')</a>
                            </li>
                            <li {!! (Route::currentRouteName() == 'shop_credits') ? 'class="active"' : '' !!}>
                                <a role="presentation" href="{{ route_with_subdomain('shop_credits') }}">@lang('app.front.shop.menu.credits')</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @yield('section_title')
                    </div>
                    
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
                        
                        <div class="products">
                            @yield('section_content')
                        </div>
                    </div>
                </div>
                
                @yield('section_content2')
                
                @yield('section_content3')
            </div>
        </div>
    </div>
@endsection
