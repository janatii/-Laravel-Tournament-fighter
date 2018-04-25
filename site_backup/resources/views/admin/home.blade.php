@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.admin.dashboard.title')</div>

            <div class="panel-body">
                @lang('app.admin.dashboard.description')
            </div>
        </div>
    </div>
</div>
@endsection
