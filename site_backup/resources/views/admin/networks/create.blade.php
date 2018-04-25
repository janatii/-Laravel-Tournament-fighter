@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('app.admin.networks.add-title')
            </div>
            
            <form method="post" action="{{ route('admin_networks_create_submit') }}" enctype="multipart/form-data">
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
                    
                </div>
                
                <div class="panel-footer text-right">
                    <a class="btn btn-danger" href="{{ route('admin_networks_list') }}">@lang('app.global.generic-texts.back')</a>
                    <input type="submit" class="btn btn-primary" value="@lang('app.global.generic-texts.save')">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
