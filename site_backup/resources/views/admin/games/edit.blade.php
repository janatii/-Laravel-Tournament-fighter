@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('app.admin.games.edit-title', ['name' => $game->name])
            </div>
            
            <form method="post" action="{{ route('admin_games_edit_submit', $game) }}" enctype="multipart/form-data">
                <div class="panel-body">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.name'),
                        'name' => 'name',
                        'value' => $game->name,
                        'required' => true,
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.subdomain'),
                        'name' => 'subdomain',
                        'value' => $game->subdomain,
                        'required' => true,
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.order'),
                        'name' => 'order',
                        'type' => 'number',
                        'value' => $game->order,
                        'required' => true,
                        'attributes' => [
                            'min' => 1,
                        ]
                    ])
    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.max-players-per-team'),
                        'name' => 'max_players_per_team',
                        'type' => 'number',
                        'value' => $game->max_players_per_team,
                        'required' => true,
                        'attributes' => [
                            'min' => 1,
                        ]
                    ])
    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.max-teams-per-player'),
                        'name' => 'max_teams_per_player',
                        'type' => 'number',
                        'value' => $game->max_teams_per_player,
                        'required' => true,
                        'attributes' => [
                            'min' => 1,
                        ]
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.max-teams-per-player-premium'),
                        'name' => 'max_teams_per_player_premium',
                        'type' => 'number',
                        'value' => $game->max_teams_per_player_premium,
                        'required' => true,
                        'attributes' => [
                            'min' => 1,
                        ]
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.bo-list'),
                        'name' => 'bo_list',
                        'value' => $game->bo_list,
                        'required' => true
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.vs-list'),
                        'name' => 'vs_list',
                        'value' => $game->vs_list,
                        'required' => true
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.classic-modes-list'),
                        'name' => 'classic_modes_list',
                        'value' => $game->classic_modes_list,
                        'required' => true
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.time_per_round'),
                        'name' => 'time_per_round',
                        'type' => 'number',
                        'value' => $game->time_per_round,
                        'required' => true,
                        'attributes' => [
                            'min' => 1,
                        ]
                    ])
                    
                    @include('forms.input', [
                        'type' => 'file',
                        'subtype' => 'img',
                        'label' => trans('app.global.forms-fields.logo'),
                        'name' => 'logo',
                        'required' => false,
                        'value' => $game->logo,
                        'help' => trans('app.global.forms-fields.images-formats-help')
                    ])
    
                    @include('forms.input', [
                        'type' => 'file',
                        'subtype' => 'img',
                        'label' => trans('app.global.forms-fields.menu-logo'),
                        'name' => 'menu_logo',
                        'required' => false,
                        'value' => $game->menu_logo,
                        'help' => trans('app.global.forms-fields.images-formats-help')
                    ])
                    
                    @include('forms.input', [
                        'type' => 'file',
                        'subtype' => 'img',
                        'label' => trans('app.global.forms-fields.logo-list-trainings'),
                        'name' => 'logo_list_trainings',
                        'required' => false,
                        'value' => $game->logo_list_trainings,
                        'help' => trans('app.global.forms-fields.images-formats-help')
                    ])
                    
                    @include('forms.input', [
                        'type' => 'file',
                        'subtype' => 'img',
                        'label' => trans('app.global.forms-fields.banner'),
                        'name' => 'banner',
                        'required' => false,
                        'value' => $game->banner,
                        'help' => trans('app.global.forms-fields.images-formats-help')
                    ])
                    
                    <div class="form-group {{ $errors->has('rules') ? 'has-error' : '' }}">
                        <label class="control-label" for="rules">
                            @lang('app.global.forms-fields.rules')
                        </label>
                        <span class="text-muted">(@lang('app.global.generic-texts.required'))</span>
                        @if($errors->has('rules'))
                            <span class="help-block">
                                <p class="text-danger">
                                    {{ $errors->first('rules') }}
                                </p>
                            </span>
                        @endif
                        <textarea class="form-control" name="rules" id="rules" rows="20">{!! $game->rules !!}</textarea>
                    </div>
                    
                    <hr>
                    
                    @include('forms.select', [
                        'label' => trans('app.global.forms-fields.network'),
                        'name' => 'network',
                        'options' => $networks,
                        'selected' => $game->network->id,
                        'required' => true
                    ])
                    
                    @include('forms.select', [
                        'label' => trans('app.global.forms-fields.platform'),
                        'name' => 'platform',
                        'options' => $platforms,
                        'selected' => $game->platform->id,
                        'required' => true
                    ])
                    
                </div>
                
                <div class="panel-footer text-right">
                    <a class="btn btn-primary" href="{{ route('admin_gamemodes_list', ['game' => $game->id]) }}">@lang('app.global.generic-texts.gamemodes')</a>
                    <a class="btn btn-primary" href="{{ route('admin_maps_list', ['game' => $game->id]) }}">@lang('app.global.generic-texts.maps')</a>
                    
                    <a class="btn btn-danger" href="{{ route('admin_games_list') }}">@lang('app.global.generic-texts.back')</a>
                    <input type="submit" class="btn btn-primary" value="@lang('app.global.generic-texts.save')">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
