@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('app.admin.users.show-title', ['username' => $user->username])
            </div>
            
            <div class="panel-body">
                <form class="form-horizontal">
                    @include('forms.static', [
                        'label' => trans('app.global.forms-fields.username'),
                        'value' => $user->username
                    ])
                    @include('forms.static', [
                        'label' => trans('app.global.forms-fields.firstname'),
                        'value' => $user->firstname
                    ])
                    @include('forms.static', [
                        'label' => trans('app.global.forms-fields.lastname'),
                        'value' => $user->lastname
                    ])
                    @include('forms.static', [
                        'label' => trans('app.global.forms-fields.birthdate'),
                        'value' => $user->birthdate ? $user->birthdate->format(LocalizationFormats::getFormat('date')) : ''
                    ])
                    @include('forms.static', [
                        'label' => trans('app.global.forms-fields.email'),
                        'subtype' => 'confirmable-email',
                        'value' => $user->email,
                        'subvalue' => $user->email_confirmed
                    ])
                    @include('forms.static', [
                        'label' => trans('app.global.forms-fields.roles'),
                        'value' => $user->roles
                    ])
                </form>
            </div>
            
            <div class="panel-footer text-right">
                <a class="btn btn-danger" href="{{ route('admin_users_list') }}">@lang('app.global.generic-texts.back')</a>
            </div>
        </div>
    </div>
</div>
@endsection
