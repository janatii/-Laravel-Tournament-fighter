<?php
$value = isset($value) ? $value : null;
$type = isset($type) ? $type : 'text';
$subtype = isset($subtype) ? $subtype : null;
$subvalue = isset($subvalue) ? $subvalue : null;
?>
@if($subtype == 'img')
    <div class="form-group">
        <img src="{{ $subvalue }}" alt="@lang('app.global.generic-texts.current')" class="img-rounded">
    </div>
@endif
<div class="form-group">
    <label class="control-label col-md-2">{{ $label }}</label>
    <div class="col-md-10">
        <p class="form-control-static">
            @if($value instanceof \Illuminate\Support\Collection)
                @foreach($value as $item)
                    {{ $item }}<br>
                @endforeach
            @else
                {{ $value }}
            @endif
        </p>
        @if($subtype == 'confirmable-email' && !$subvalue)
            <span class="help-block">
            <p class="text-warning">
                @lang('app.global.generic-texts.not-confirmed')
            </p>
        </span>
        @endif
    </div>
</div>
