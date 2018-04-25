@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('app.admin.gamemodes.edit-title', ['name' => $gamemode->name])
            </div>
            
            <form method="post" action="{{ route('admin_gamemodes_edit_submit', ['game' => $game, 'gamemode' => $gamemode]) }}" enctype="multipart/form-data">
                <div class="panel-body">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.name'),
                        'name' => 'name',
                        'value' => $gamemode->name,
                        'required' => true,
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.abbrev'),
                        'name' => 'abbrev',
                        'value' => $gamemode->abbrev,
                        'required' => true
                    ])
                </div>
                
                <div class="panel-footer text-right">
                    <a class="btn btn-danger" href="{{ route('admin_gamemodes_list', ['game' => $game]) }}">@lang('app.global.generic-texts.back')</a>
                    <input type="submit" class="btn btn-primary" value="@lang('app.global.generic-texts.save')">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
