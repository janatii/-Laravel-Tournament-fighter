@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('app.admin.users.show-title', ['username' => $user->username])
            </div>
            
            <form method="post" action="{{ route('admin_users_user', $user) }}" enctype="multipart/form-data">
                <div class="panel-body">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.username'),
                        'name' => 'username',
                        'value' => $user->username,
                        'required' => true,
                        'help' => trans('app.global.forms-fields.username-help')
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
                    
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email" class="control-label">@lang('app.global.forms-fields.email')</label>
                        <span class="text-muted">(@lang('app.global.generic-texts.required')</span>
                        <div class="input-group">
                            <input class="form-control"
                                   type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   required>
                            <span class="input-group-addon">
                                <label class="control-label" for="force_email_confirmation">@lang('app.global.generic-texts.confirm')</label>
                                <input type="checkbox"
                                       id="force_email_confirmation"
                                       name="force_email_confirmation"
                                       value="1">
                            </span>
                        </div>
                        @if($errors->has('email'))
                            <span class="help-block">
                                <p class="text-danger">
                                    {{ $errors->first('email') }}
                                </p>
                            </span>
                        @elseif($user->email_confirmed === null)
                            <span class="help-block">
                                <p class="text-warning">
                                    @lang('app.admin.users.email-not-confirmed') - <a href="{{ route('admin_users_send_confirmation_email', $user) }}">@lang('app.admin.users.send-confirmation-email')</a>
                                </p>
                            </span>
                        @endif
                    </div>
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.password'),
                        'name' => 'password',
                        'type' => 'password',
                        'required' => false
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.credits'),
                        'name' => 'credits',
                        'value' => $user->credits,
                        'required' => true
                    ])
    
                    <hr>
                    
                    @include('forms.input', [
                        'type' => 'file',
                        'subtype' => 'img',
                        'label' => trans('app.global.forms-fields.avatar'),
                        'name' => 'avatar',
                        'required' => false,
                        'value' => $user->avatar,
                        'help' => trans('app.global.forms-fields.images-formats-help')
                    ])
                    @if($user->avatar && is_numeric(basename($user->avatar)))
                        <div class="form-group">
                            <button type="button" id="remove-avatar-button" class="btn btn-danger">@lang('app.global.generic-texts.remove')</button>
                        </div>
                    @endif
                    
                    <hr>
                    
                    @include('forms.select', [
                        'label' => trans('app.global.forms-fields.roles'),
                        'name' => 'roles',
                        'options' => $roles,
                        'selected' => $user->roles,
                        'multiple' => true,
                        'required' => false,
                        'size' => count($roles)
                    ])
                </div>
                
                <div class="panel-footer text-right">
                    <a class="btn btn-danger" href="{{ route('admin_users_list') }}">@lang('app.global.generic-texts.back')</a>
                    <input type="submit" class="btn btn-primary" value="@lang('app.global.generic-texts.save')">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        $('#remove-avatar-button').click(function (e) {
            e.preventDefault();
            
            confirmModal("@lang('app.admin.users.confirm-remove-avatar')", function() {
                $('<form>', { action: '{{ route('admin_users_avatar', ['user' => $user]) }}', method: 'post' })
                    .append('{{ csrf_field() }}')
                    .append('{{ method_field('delete') }}')
                    .appendTo('body')
                    .submit();
            });
        });
    })();
</script>
@endpush