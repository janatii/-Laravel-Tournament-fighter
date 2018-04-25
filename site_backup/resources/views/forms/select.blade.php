<?php

use Illuminate\Support\Collection as SupportCollection;

$options = isset($options) ? $options : null;
$selected = old($name, isset($selected) ? $selected : []);
$required = isset($required) ? (bool)$required : false;
$help = isset($help) ? $help : null;
$multiple = isset($multiple) ? (bool)$multiple : false;
$size = isset($size) ? $size : 5;

if (!($options instanceof SupportCollection)) {
    $options = collect($options);
}

if (!($selected instanceof SupportCollection)) {
    $selected = collect(is_array($selected) ? $selected : [$selected]);
}

$firstOption = $options->first();
$optionValueKey = isset($optionValueKey) ? $optionValueKey : ($firstOption instanceof \Illuminate\Database\Eloquent\Model ? $firstOption->getKeyName() : null);
$optionLabelKey = isset($optionLabelKey) ? $optionLabelKey : null;

?>
<div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
    <label for="{{ $name }}" class="control-label">{{ $label }}</label>
    @if($required)
        <span class="text-muted">(@lang('app.global.generic-texts.required'))</span>
    @endif
    <select class="form-control"
            id="{{ $name }}"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            @if($multiple)
                multiple
                size="{{ $size }}"
            @endif
            {{ $required ? 'required' : '' }}>
            @foreach($options as $optionKey => $option)
                <option value="{{ $optionValueKey ? $option[$optionValueKey] : $option }}" @if(isset($compFunc) && is_callable($compFunc) ? $compFunc($selected, $option) : $selected->contains($optionValueKey ? $option[$optionValueKey] : $option)) selected @endif>
                    {{ $optionLabelKey ? ($optionLabelKey == 'array_keys' ? $optionKey : $option[$optionLabelKey]) : $option }}
                </option>
            @endforeach
    </select>
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

