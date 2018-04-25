@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('app.admin.platforms.edit-title', ['name' => $platform->name])
            </div>
            
            <form method="post" action="{{ route('admin_platforms_edit_submit', $platform) }}" enctype="multipart/form-data">
                <div class="panel-body">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.name'),
                        'name' => 'name',
                        'value' => $platform->name,
                        'required' => true,
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.order'),
                        'name' => 'order',
                        'type' => 'number',
                        'value' => $platform->order,
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
                        'value' => $platform->logo,
                        'help' => trans('app.global.forms-fields.images-formats-help')
                    ])
                    
                </div>
                
                <div class="panel-footer text-right">
                    <a class="btn btn-danger" href="{{ route('admin_platforms_list') }}">@lang('app.global.generic-texts.back')</a>
                    <input type="submit" class="btn btn-primary" value="@lang('app.global.generic-texts.save')">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
