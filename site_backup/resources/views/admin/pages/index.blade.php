@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">@lang('app.admin.pages.list-title')</h2>
            </div>
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>@lang('app.global.forms-fields.order')</th>
                            <th>@lang('app.global.forms-fields.title')</th>
                            <th>@lang('app.global.forms-fields.language')</th>
                            <th>@lang('app.global.forms-fields.url')</th>
                            <th>@lang('app.global.forms-fields.visible-in-menu')</th>
                            <th>@lang('app.global.generic-texts.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $page)
                                <tr>
                                    <td>
                                        {{ $page->order }}
                                    </td>
                                    <td>
                                        {{ $page->title }}
                                    </td>
                                    <td>
                                        {{ $page->lang }}
                                    </td>
                                    <td>
                                        {{ $page->url }}
                                    </td>
                                    <td>
                                        {{ $page->visible_in_menu ? trans('app.global.generic-texts.yes') : trans('app.global.generic-texts.no') }}
                                    </td>
                                    <td>
                                        <a class="btn btn-success" href="{{ route('admin_pages_edit', $page) }}">@lang('app.global.generic-texts.edit')</a>
                                
                                        <form class="inline-block js-confirmable-form" action="{{ route('admin_pages_delete', $page) }}" method="post" data-confirm="@lang('app.admin.pages.confirm-delete', ['title' => $page->title])">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button class="btn btn-danger">@lang('app.global.generic-texts.delete')</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        @lang('app.admin.pages.no-pages')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="panel-footer">
                <a class="btn btn-primary" href="{{ route('admin_pages_create') }}">@lang('app.global.generic-texts.add')</a>
            </div>
        </div>
    </div>
</div>
@endsection
