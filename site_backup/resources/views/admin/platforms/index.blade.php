@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">@lang('app.admin.platforms.list-title')</h2>
            </div>
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>@lang('app.global.forms-fields.order')</th>
                            <th>@lang('app.global.forms-fields.name')</th>
                            <th>@lang('app.global.forms-fields.logo')</th>
                            <th>@lang('app.global.generic-texts.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($platforms as $platform)
                                <tr>
                                    <td>
                                        {{ $platform->order }}
                                    </td>
                                    <td>
                                        {{ $platform->name }}
                                    </td>
                                    <td>
                                        <img src="{{ $platform->logo }}" alt="@lang('app.global.forms-fields.logo')" title="{{ $platform->name }}">
                                    </td>
                                    <td>
                                        <a class="btn btn-success" href="{{ route('admin_platforms_edit', $platform) }}">@lang('app.global.generic-texts.edit')</a>
                                        
                                        <form class="inline-block js-confirmable-form" action="{{ route('admin_platforms_delete', $platform) }}" method="post" data-confirm="@lang('app.admin.platforms.confirm-delete', ['name' => $platform->name])">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button class="btn btn-danger">@lang('app.global.generic-texts.delete')</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        @lang('app.admin.platforms.no-platforms')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="panel-footer">
                <a class="btn btn-primary" href="{{ route('admin_platforms_create') }}">@lang('app.global.generic-texts.add')</a>
            </div>
        </div>
    </div>
</div>
@endsection
