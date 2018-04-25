@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('app.admin.maps.add-title')
            </div>
            
            <form method="post" action="{{ route('admin_maps_create_submit', ['game' => $game]) }}" enctype="multipart/form-data">
                <div class="panel-body">
                    {{ csrf_field() }}
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.name'),
                        'name' => 'name',
                        'required' => true
                    ])
                    
                    @include('forms.input', [
                        'type' => 'file',
                        'subtype' => 'img',
                        'label' => trans('app.global.forms-fields.logo'),
                        'name' => 'logo',
                        'required' => true,
                        'help' => trans('app.global.forms-fields.images-formats-help')
                    ])
                    
                    <div class="form-group {{ $errors->has('gamemodes') ? 'has-error' : '' }}">
                        <label for="gamemodes" class="control-label">@lang('app.global.forms-fields.gamemodes')</label>
                        @foreach($gamemodes as $gamemode)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="gamemodes[]" value="{{ $gamemode->id }}" {{ !$errors->isEmpty() && in_array($gamemode->id, old('gamemodes')) ? 'checked' : '' }}> {{ $gamemode }}
                                </label>
                            </div>
                        @endforeach
                        @if($errors->has('gamemodes'))
                            <span class="help-block">
                                <p class="text-danger">
                                    {{ $errors->first('gamemodes') }}
                                </p>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="panel-footer text-right">
                    <a class="btn btn-danger" href="{{ route('admin_maps_list', ['game' => $game]) }}">@lang('app.global.generic-texts.back')</a>
                    <input type="submit" class="btn btn-primary" value="@lang('app.global.generic-texts.save')">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
