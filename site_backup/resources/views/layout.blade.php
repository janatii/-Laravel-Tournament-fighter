<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @stack('metas')
    
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <link rel="icon" type="image/png" href="/favicon-standard-iphone.png">
    <link rel="apple-touch-icon-precomposed" href="/favicon-standard-iphone.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/favicon-standard-ipad.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/favicon-retina-ipad.png">
    
    
    @stack('styles')
    
    @stack('head_scripts')
</head>
<body>
    @yield('wrapper')
    
    <div class="remodal" data-remodal-id="error-modal" role="alert" data-remodal-options="hashTracking: false">
        <button data-remodal-action="close" class="remodal-close"></button>
    
        <h1 class="text-center">
            @lang('app.global.generic-texts.oops')
        </h1>
    
        <p></p>
        
        <button data-remodal-action="cancel" type="button" class="btn btn-danger">@lang('app.global.generic-texts.ok')</button>
    </div>

    <div class="remodal" data-remodal-id="confirm-modal" role="alert" data-remodal-options="hashTracking: false">
        <button data-remodal-action="close" class="remodal-close"></button>
    
        <h1 class="text-center">
            @lang('app.global.generic-texts.confirm')
        </h1>
    
        <p></p>
    
        <button data-remodal-action="cancel" type="button" class="btn btn-danger">@lang('app.global.generic-texts.abort')</button>
        <button data-remodal-action="confirm" type="button" class="btn btn-success">@lang('app.global.generic-texts.confirm')</button>
    </div>
    
    
    <script src="{{ mix('js/common.js') }}"></script>
    
    @stack('vue-data')
    
    <script>
        var app = new Vue({
            el: '#wrapper'
        });
    </script>
    
    @stack('scripts')

    @if(session()->has('error-modal'))
        <script>
            (function() {
                errorModal("{{ session()->get('error-modal') }}");
            })();
        </script>
    @endif
</body>
</html>
