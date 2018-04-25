@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">@lang('app.admin.users.list-title')</h2>
            </div>
            
            <div class="panel-body">
                @include('partials.filters')
    
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>@lang('app.global.forms-fields.username')</th>
                            <th>@lang('app.global.forms-fields.email')</th>
                            <th>@lang('app.global.forms-fields.firstname')</th>
                            <th>@lang('app.global.forms-fields.lastname')</th>
                            <th>@lang('app.global.forms-fields.birthdate')</th>
                            <th>@lang('app.global.generic-texts.locked')</th>
                            <th>@lang('app.global.generic-texts.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->username }}
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        {{ $user->firstname }}
                                    </td>
                                    <td>
                                        {{ $user->lastname }}
                                    </td>
                                    <td>
                                        {{ $user->birthdate ? $user->birthdate->format(LocalizationFormats::getFormat('date')) : '' }}
                                    </td>
                                    <td>
                                        @if($user->lock)
                                            <form class="inline-block js-confirmable-form" action="{{ route('admin_users_unlock', $user) }}" method="post" data-confirm="@lang('app.admin.users.confirm-unlock-user', ['username' => $user->username])">
                                                {{ csrf_field() }}
                                                {{ method_field('patch') }}
                                                <button class="btn btn-danger">@lang('app.global.generic-texts.unlock')</button>
                                            </form>
                                        @else
                                            <form class="inline-block js-confirmable-form" action="{{ route('admin_users_lock', $user) }}" method="post" data-confirm="@lang('app.admin.users.confirm-lock-user', ['username' => $user->username])">
                                                {{ csrf_field() }}
                                                {{ method_field('patch') }}
                                                <button class="btn btn-warning">@lang('app.global.generic-texts.lock')</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('admin_users_user', $user) }}">@lang('app.global.generic-texts.show')</a>
                                        <a class="btn btn-success" href="{{ route('admin_users_edit', $user) }}">@lang('app.global.generic-texts.edit')</a>
                                        
                                        <form class="inline-block js-confirmable-form" action="{{ route('admin_users_user', $user) }}" method="post" data-confirm="@lang('app.admin.users.confirm-delete-user', ['username' => $user->username])">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button class="btn btn-danger">@lang('app.global.generic-texts.delete')</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        @lang('app.admin.users.no-users')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
    
                <div class="text-center">
                    {{ $users->links() }}
                </div>
            </div>
            
            <div class="panel-footer">
                <a class="btn btn-primary" href="{{ route('admin_users_create') }}">@lang('app.global.generic-texts.add')</a>
            </div>
        </div>
    </div>
</div>
@endsection
