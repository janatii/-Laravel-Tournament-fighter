@extends('front.parameters.layout')

@section('form_title')
    @lang('app.front.parameters.index.title')
@endsection

@section('form_content')
    @if(!$user->isPremium())
        <a href="{{ route_with_subdomain('shop_premium') }}" class="premium-text">
            <img src="/img/premium-icon.png" alt="" class="premium-icon"> {{ trans('app.front.parameters.become-premium-to-change-username') }}
        </a>
    @endif
    @include('forms.input', [
        'label' => trans('app.global.forms-fields.username'),
        'name' => 'username',
        'value' => $user->username,
        'required' => true,
        'help' => trans('app.global.forms-fields.username-help'),
        'readonly' => !$user->isPremium()
    ])
    
    @include('forms.input', [
        'label' => trans('app.global.forms-fields.firstname'),
        'name' => 'firstname',
        'value' => $user->firstname,
        'required' => false
    ])
    @include('forms.input', [
        'label' => trans('app.global.forms-fields.lastname'),
        'name' => 'lastname',
        'value' => $user->lastname,
        'required' => false
    ])
    @include('forms.input', [
        'label' => trans('app.global.forms-fields.birthdate'),
        'name' => 'birthdate',
        'subtype' => 'datetimepickable',
        'value' => $user->birthdate ? $user->birthdate->format(LocalizationFormats::getFormat('date')) : '',
        'required' => false,
        'help' => trans('app.global.generic-texts.example') . ' : ' . LocalizationFormats::getFormat('date', 'human')
    ])
    @include('forms.select', [
        'label' => trans('app.global.forms-fields.language'),
        'name' => 'language',
        'options' => $locales,
        'optionLabelKey' => 'array_keys',
        'selected' => App::getLocale(),
        'required' => true
    ])
@endsection

@section('form_buttons')
    <button type="submit" class="btn btn-primary">@lang('app.global.generic-texts.save')</button>
@endsection