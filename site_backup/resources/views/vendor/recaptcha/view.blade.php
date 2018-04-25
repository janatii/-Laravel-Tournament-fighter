<?php
if ( ! function_exists('renderDataAttributes')) {
    function renderDataAttributes($attributes)
    {
        $mapped = [ ];
        foreach ($attributes as $key => $value) {
            $mapped[] = 'data-' . $key . '="' . $value . '"';
        };
        return implode(' ', $mapped);
    }
}
?>
<div class="g-recaptcha" data-sitekey="{{ $public_key }}" <?=renderDataAttributes($dataParams)?>></div>
<noscript>
    <iframe src="https://www.google.com/recaptcha/api/fallback?k={{ $public_key }}"
            frameborder="0" scrolling="no"
            style="width: 302px; height: 425px; border-style: none;">
    </iframe>
</noscript>

@push('head_scripts')
    @if(!empty($options))
        <script type="text/javascript">
            var RecaptchaOptions = <?=json_encode($options) ?>;
        </script>
    @endif
    <script src="https://www.google.com/recaptcha/api.js?hl={{ App::getLocale() }}"></script>
@endpush