@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">@lang('app.admin.referee.list-title')</h2>
            </div>
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>@lang('app.global.forms-fields.id')</th>
                            <th>@lang('app.global.forms-fields.team1')</th>
                            <th>@lang('app.global.forms-fields.team2')</th>
                            <th>@lang('app.global.generic-texts.link')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($matchs as $match)
                                <tr>
                                    <td>
                                        {{ $match->id }}
                                    </td>
                                    <td>
                                        {{ $match->squad1->team->name }}
                                    </td>
                                    <td>
                                        {{ $match->squad2->team->name }}
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('training_show', ['match' => $match, 'subdomain' => $match->game->subdomain]) }}">
                                            {{ trans('app.global.generic-texts.see') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        @lang('app.admin.referee.no-match')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
    
                <div class="text-center">
                    {{ $matchs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
