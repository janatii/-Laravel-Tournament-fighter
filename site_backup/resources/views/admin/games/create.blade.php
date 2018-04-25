@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('app.admin.games.add-title')
            </div>
            
            <form method="post" action="{{ route('admin_games_create_submit') }}" enctype="multipart/form-data">
                <div class="panel-body">
                    {{ csrf_field() }}
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.name'),
                        'name' => 'name',
                        'required' => true
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.subdomain'),
                        'name' => 'subdomain',
                        'required' => true
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.order'),
                        'name' => 'order',
                        'type' => 'number',
                        'required' => true,
                        'attributes' => [
                            'min' => 1,
                        ]
                    ])
    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.max-players-per-team'),
                        'name' => 'max_players_per_team',
                        'type' => 'number',
                        'required' => true,
                        'attributes' => [
                            'min' => 1,
                        ]
                    ])
    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.max-teams-per-player'),
                        'name' => 'max_teams_per_player',
                        'type' => 'number',
                        'required' => true,
                        'attributes' => [
                            'min' => 1,
                        ]
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.max-teams-per-player-premium'),
                        'name' => 'max_teams_per_player_premium',
                        'type' => 'number',
                        'required' => true,
                        'attributes' => [
                            'min' => 1,
                        ]
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.bo-list'),
                        'name' => 'bo_list',
                        'required' => true
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.vs-list'),
                        'name' => 'vs_list',
                        'required' => true
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.classic-modes-list'),
                        'name' => 'classic_modes_list',
                        'required' => true
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.time_per_round'),
                        'name' => 'time_per_round',
                        'type' => 'number',
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
                        'required' => true,
                        'help' => trans('app.global.forms-fields.images-formats-help')
                    ])
    
                    @include('forms.input', [
                        'type' => 'file',
                        'subtype' => 'img',
                        'label' => trans('app.global.forms-fields.menu-logo'),
                        'name' => 'menu_logo',
                        'required' => true,
                        'help' => trans('app.global.forms-fields.images-formats-help')
                    ])
                    
                    @include('forms.input', [
                        'type' => 'file',
                        'subtype' => 'img',
                        'label' => trans('app.global.forms-fields.logo-list-trainings'),
                        'name' => 'logo_list_trainings',
                        'required' => true,
                        'help' => trans('app.global.forms-fields.images-formats-help')
                    ])
    
                    @include('forms.input', [
                        'type' => 'file',
                        'subtype' => 'img',
                        'label' => trans('app.global.forms-fields.banner'),
                        'name' => 'banner',
                        'required' => true,
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
                        <textarea class="form-control" name="rules" id="rules" rows="20"></textarea>
                    </div>
                    
                    <hr>
                    
                    @include('forms.select', [
                        'label' => trans('app.global.forms-fields.network'),
                        'name' => 'network',
                        'options' => $networks,
                        'required' => true
                    ])
                    
                    @include('forms.select', [
                        'label' => trans('app.global.forms-fields.platform'),
                        'name' => 'platform',
                        'options' => $platforms,
                        'required' => true
                    ])
                    
                </div>
                
                <div class="panel-footer text-right">
                    <a class="btn btn-danger" href="{{ route('admin_games_list') }}">@lang('app.global.generic-texts.back')</a>
                    <input type="submit" class="btn btn-primary" value="@lang('app.global.generic-texts.save')">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
