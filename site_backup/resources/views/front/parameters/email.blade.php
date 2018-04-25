@extends('front.parameters.layout')

@section('form_title')
    @lang('app.front.parameters.change-email.title')
@endsection

@section('form_content')
    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <label for="email" class="control-label">@lang('app.global.forms-fields.email')</label>
        <span class="text-muted">(@lang('app.global.generic-texts.required'))</span>
        <input class="form-control"
               type="email"
               id="email"
               name="email"
               value="{{ old('email', $user->email) }}"
               required>
        @if($errors->has('email'))
            <span class="help-block">
                <p class="text-danger">
                    {{ $errors->first('email') }}
                </p>
            </span>
        @elseif($user->email_confirmed === null)
            <span class="help-block">
                <p class="text-warning">
                    @lang('app.front.parameters.change-email.email-not-confirmed') - <a href="{{ route_with_subdomain('parameters_send_confirmation_email') }}">@lang('app.front.parameters.change-email.send-confirmation-email')</a>
                </p>
            </span>
        @endif
    </div>
    
    @include('forms.input', [
        'label' => trans('app.front.parameters.change-email.confirm-password'),
        'name' => 'password',
        'type' => 'password',
        'required' => true
    ])
@endsection

@section('form_buttons')
    <button type="submit" class="btn btn-primary">@lang('app.global.generic-texts.save')</button>
@endsection
