@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">@lang('app.admin.maps.list-title')</h2>
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
                            @forelse($maps as $map)
                                <tr>
                                    <td>
                                        {{ $map->name }}
                                    </td>
                                    <td>
                                        <img src="{{ $map->logo }}" alt="@lang('app.global.forms-fields.logo')" title="{{ $map->name }}">
                                    </td>
                                    <td>
                                        <a class="btn btn-success" href="{{ route('admin_maps_edit', ['game' => $game, 'map' => $map]) }}">@lang('app.global.generic-texts.edit')</a>
                                        <form class="inline-block js-confirmable-form" action="{{ route('admin_maps_delete', ['game' => $game, 'map' => $map]) }}" method="post" data-confirm="@lang('app.admin.maps.confirm-delete', ['name' => $map->name])">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button class="btn btn-danger">@lang('app.global.generic-texts.delete')</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">
                                        @lang('app.admin.maps.no-maps')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="panel-footer">
                <a class="btn btn-danger" href="{{ route('admin_games_edit', ['game' => $game]) }}">@lang('app.global.generic-texts.back')</a>
                <a class="btn btn-primary" href="{{ route('admin_maps_create', ['game' => $game]) }}">@lang('app.global.generic-texts.add')</a>
            </div>
        </div>
    </div>
</div>
@endsection
