<?php
$value = isset($value) ? $value : null;
$type = isset($type) ? $type : 'text';
$required = isset($required) ? (bool)$required : false;
$help = isset($help) ? $help : null;
$subtype = isset($subtype) ? $subtype : null;
$subvalue = isset($subvalue) ? $subvalue : null;
$readonly = isset($readonly) ? (bool)$readonly : false;
$checked = isset($checked) ? (bool)$checked : false;
$attributes = isset($attributes) ? $attributes : [];

if ($subtype === 'datetimepickable') {
    $readonly = true;
}

?>
<div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
    <label for="{{ $name }}" class="control-label">{{ $label }}</label>
    @if($required)
        <span class="text-muted">(@lang('app.global.generic-texts.required'))</span>
    @endif
    @if($subtype === 'datetimepickable')
        <div class="input-group date datetimepicker">
    @endif
    <input class="form-control"
           type="{{ $type }}"
           id="{{ $name }}"
           name="{{ $name }}"
           value="{{ $type != 'password' ? old($name, $value) : '' }}"
           {{ $required ? 'required' : '' }}
           {{ $readonly ? 'readonly' : '' }}
           {{ $checked ? 'checked' : '' }}
           @foreach($attributes as $attrName => $attrValue)
               {{ $attrName }}="{{ $attrValue }}"
           @endforeach
           @if($subtype == 'img')accept="image/jpeg, image/png"@endif
           >
    @if($subtype === 'datetimepickable')
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    @endif
    @if($help)
        <span class="help-block">
            <p class="text-muted">
                {{ $help }}
            </p>
        </span>
    @endif
    @if($errors->has($name))
        <span class="help-block">
            <p class="text-danger">
                {{ $errors->first($name) }}
            </p>
        </span>
    @endif
</div>

@if($subtype == 'img')
    <div class="form-group">
        <img id="{{ $name }}Img" src="{{ $value ?: '/img/empty.png' }}" alt="@lang('app.global.generic-texts.current')" class="img-rounded">
    </div>
@endif

@if($subtype === 'datetimepickable')
    @push('styles')
        <link href="/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
    @endpush
    
    @push('scripts')
        <script src="/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        @if(App::getLocale() != 'en')
            <script src="/vendor/bootstrap-datetimepicker/locales/bootstrap-datetimepicker.{{ App::getLocale() }}.js"></script>
        @endif
        <script type="text/javascript">
            $(".datetimepicker").datetimepicker({
                format: '{{ LocalizationFormats::getFormat('date', 'js') }}',
                language:  '{{ App::getLocale() }}',
                weekStart: 1,
                todayBtn:  true,
                clearBtn:  true,
                todayHighlight: true,
                startView: 4,
                minView: 2,
                forceParse: false,
                showMeridian: '{{ App::getLocale() }}' == 'en',
                pickerPosition: 'bottom-left',
                fontAwesome: true
            });
        </script>
    @endpush
@elseif($subtype === 'img')
    @push('scripts')
        <script type="text/javascript">
            $('#{{ $name }}').change(function(){
                readURL(this, '#{{ $name }}Img');
            });
        </script>
    @endpush
@endif
