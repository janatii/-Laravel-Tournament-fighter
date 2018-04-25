@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">@lang('app.admin.wallet.list-title')</h2>
            </div>
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>@lang('app.global.forms-fields.id')</th>
                            <th>@lang('app.admin.wallet.credits')</th>
                            <th>@lang('app.admin.wallet.infos')</th>
                            <th>@lang('app.global.generic-texts.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($asks as $ask)
                                <tr>
                                    <td>
                                        {{ $ask->id }}
                                    </td>
                                    <td>
                                        {{ $ask->credits }}
                                    </td>
                                    <td>
                                        <a href="{{ route_with_subdomain('profile_main', ['username' => $ask->user->username]) }}">
                                            {{ $ask->user->username }} ID#{{ $ask->user->id }}
                                        </a>
                                        <br>
                                        {{ trans('app.admin.wallet.paypal-or-bank') }} :<br>
                                        {{ $ask->infos }}
                                    </td>
                                    <td>
                                        <form action="{{ route_with_subdomain('admin_wallet_done', ['ask' => $ask]) }}" method="post">
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger">
                                                @lang('app.admin.wallet.mark-done')
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        @lang('app.admin.wallet.no-ask')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
    
                <div class="text-center">
                    {{ $asks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
