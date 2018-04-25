@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('app.admin.pages.add-title')
            </div>
            
            <form method="post" action="{{ route('admin_pages_create_submit') }}" enctype="multipart/form-data">
                <div class="panel-body">
                    {{ csrf_field() }}
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.title'),
                        'name' => 'title',
                        'required' => true
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.language'),
                        'name' => 'lang',
                        'required' => true
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.url'),
                        'name' => 'url',
                        'required' => true
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.order'),
                        'name' => 'order',
                        'required' => true
                    ])
                    
                    @include('forms.input', [
                        'label' => trans('app.global.forms-fields.visible-in-menu'),
                        'name' => 'visible_in_menu',
                        'type' => 'checkbox',
                        'value' => 1,
                        'checked' => false
                    ])
    
                    <label class="control-label" for="content">@lang('app.global.forms-fields.content')</label>
                    <span class="text-muted">(@lang('app.global.generic-texts.required'))</span>
                    <textarea class="form-control" name="content" id="content" rows="40" required></textarea>
                </div>
                
                <div class="panel-footer text-right">
                    <a class="btn btn-danger" href="{{ route('admin_pages_list') }}">@lang('app.global.generic-texts.back')</a>
                    <input type="submit" class="btn btn-primary" value="@lang('app.global.generic-texts.save')">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
