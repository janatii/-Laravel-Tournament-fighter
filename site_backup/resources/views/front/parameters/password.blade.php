@extends('front.parameters.layout')

@section('form_title')
    @lang('app.front.parameters.change-password.title')
@endsection

@section('form_content')
    @include('forms.input', [
        'label' => trans('app.front.parameters.change-password.confirm-password'),
        'name' => 'old_password',
        'type' => 'password',
        'required' => true
    ])

    @include('forms.input', [
        'label' => trans('app.front.parameters.change-password.new-password'),
        'name' => 'new_password',
        'type' => 'password',
        'required' => true
    ])

    @include('forms.input', [
        'label' => trans('app.front.parameters.change-password.repeat-new-password'),
        'name' => 'new_password_confirmation',
        'type' => 'password',
        'required' => true
    ])
@endsection

@section('form_buttons')
    <button type="submit" class="btn btn-primary">@lang('app.global.generic-texts.save')</button>
@endsection