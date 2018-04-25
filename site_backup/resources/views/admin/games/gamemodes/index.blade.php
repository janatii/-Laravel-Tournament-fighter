@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">@lang('app.admin.gamemodes.list-title')</h2>
            </div>
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>@lang('app.global.forms-fields.name')</th>
                            <th>@lang('app.global.generic-texts.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($gamemodes as $gamemode)
                                <tr>
                                    <td>
                                        {{ $gamemode->name }}
                                    </td>
                                    <td>
                                        <a class="btn btn-success" href="{{ route('admin_gamemodes_edit', ['game' => $game, 'gamemode' => $gamemode]) }}">@lang('app.global.generic-texts.edit')</a>
                                        <form class="inline-block js-confirmable-form" action="{{ route('admin_gamemodes_delete', ['game' => $game, 'gamemode' => $gamemode]) }}" method="post" data-confirm="@lang('app.admin.gamemodes.confirm-delete', ['name' => $gamemode->name])">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button class="btn btn-danger">@lang('app.global.generic-texts.delete')</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">
                                        @lang('app.admin.gamemodes.no-gamemodes')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="panel-footer">
                <a class="btn btn-danger" href="{{ route('admin_games_edit', ['game' => $game]) }}">@lang('app.global.generic-texts.back')</a>
                <a class="btn btn-primary" href="{{ route('admin_gamemodes_create', ['game' => $game]) }}">@lang('app.global.generic-texts.add')</a>
            </div>
        </div>
    </div>
</div>
@endsection
