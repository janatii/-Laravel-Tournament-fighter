@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">@lang('app.admin.games.list-title')</h2>
            </div>
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>@lang('app.global.forms-fields.order')</th>
                            <th>@lang('app.global.forms-fields.name')</th>
                            <th>@lang('app.global.forms-fields.subdomain')</th>
                            <th>@lang('app.global.forms-fields.logo')</th>
                            <th>@lang('app.global.forms-fields.menu-logo')</th>
                            <th>@lang('app.global.forms-fields.banner')</th>
                            <th>@lang('app.global.generic-texts.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($games as $game)
                                <tr>
                                    <td>
                                        {{ $game->order }}
                                    </td>
                                    <td>
                                        {{ $game->name }}
                                    </td>
                                    <td>
                                        {{ $game->subdomain }}
                                    </td>
                                    <td>
                                        <img src="{{ $game->logo }}" alt="@lang('app.global.forms-fields.logo')" title="{{ $game->name }}">
                                    </td>
                                    <td>
                                        <img src="{{ $game->menu_logo }}" alt="@lang('app.global.forms-fields.menu-logo')" title="{{ $game->name }}">
                                    </td>
                                    <td>
                                        <img src="{{ $game->banner }}" alt="@lang('app.global.forms-fields.banner')" title="{{ $game->name }}">
                                    </td>
                                    <td>
                                        @if($game->published)
                                            <form class="inline-block js-confirmable-form" action="{{ route('admin_games_unpublish', $game) }}" method="post" data-confirm="@lang('app.admin.games.confirm-unpublish', ['name' => $game->name])">
                                                {{ csrf_field() }}
                                                {{ method_field('patch') }}
                                                <button class="btn btn-danger">@lang('app.global.generic-texts.unpublish')</button>
                                            </form>
                                        @else
                                            <form class="inline-block js-confirmable-form" action="{{ route('admin_games_publish', $game) }}" method="post" data-confirm="@lang('app.admin.games.confirm-publish', ['name' => $game->name])">
                                                {{ csrf_field() }}
                                                {{ method_field('patch') }}
                                                <button class="btn btn-warning">@lang('app.global.generic-texts.publish')</button>
                                            </form>
                                        @endif
                                        <a class="btn btn-success" href="{{ route('admin_games_edit', $game) }}">@lang('app.global.generic-texts.edit')</a>
                                        <form class="inline-block js-confirmable-form" action="{{ route('admin_games_delete', $game) }}" method="post" data-confirm="@lang('app.admin.games.confirm-delete', ['name' => $game->name])">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button class="btn btn-danger">@lang('app.global.generic-texts.delete')</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        @lang('app.admin.games.no-games')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <a class="btn btn-primary" href="{{ route('admin_games_create') }}">@lang('app.global.generic-texts.add')</a>
            </div>
        </div>
    </div>
</div>
@endsection
