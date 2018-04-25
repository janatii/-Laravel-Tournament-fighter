@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">@lang('app.admin.networks.list-title')</h2>
            </div>
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>@lang('app.global.forms-fields.name')</th>
                            <th>@lang('app.global.forms-fields.logo')</th>
                            <th>@lang('app.global.generic-texts.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($networks as $network)
                                <tr>
                                    <td>
                                        {{ $network->name }}
                                    </td>
                                    <td>
                                        <img src="{{ $network->logo }}" alt="@lang('app.global.forms-fields.logo')" title="{{ $network->name }}">
                                    </td>
                                    <td>
                                        <a class="btn btn-success" href="{{ route('admin_networks_edit', $network) }}">@lang('app.global.generic-texts.edit')</a>
                                        
                                        <form class="inline-block js-confirmable-form" action="{{ route('admin_networks_delete', $network) }}" method="post" data-confirm="@lang('app.admin.networks.confirm-delete', ['name' => $network->name])">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button class="btn btn-danger">@lang('app.global.generic-texts.delete')</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        @lang('app.admin.networks.no-networks')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="panel-footer">
                <a class="btn btn-primary" href="{{ route('admin_networks_create') }}">@lang('app.global.generic-texts.add')</a>
            </div>
        </div>
    </div>
</div>
@endsection
