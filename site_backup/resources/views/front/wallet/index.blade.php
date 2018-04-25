@extends('front.layout')

@section('content')
    <div class="bancanopy">
        <div class="bancanopy-inner">
            <div class="bancanopy-header">
                <div class="bancanopy-header-bg" id="bannerImg" style="background-image: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.55)), url('{{ Auth::user()->banner }}')">
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('app.front.wallet.title') }}
                    </div>

                    @unless($askAlreadyExists)
                        <form action="{{ route_with_subdomain('wallet_send') }}" method="post">
                            <div class="panel-body">
                                @if(session()->has('errors'))
                                    <div class="alert alert-danger" role="alert">
                                        @lang('app.global.generic-texts.errors-occured')
                                    </div>
                                @elseif(session()->has('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @elseif(session()->has('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
    
                                {{ csrf_field() }}
    
                                @include('forms.input', [
                                    'label' => trans('app.front.wallet.credits'),
                                    'name' => 'credits',
                                    'value' => 50,
                                    'type' => 'number',
                                    'required' => true
                                ])
                                <div id="creditsValueZone">
                                    {{ trans('app.front.wallet.exchange-for') }}
                                    <span id="creditsValue">0.72</span> €
                                </div>
                                <br><br>
                                
                                @include('forms.input', [
                                    'label' => trans('app.front.wallet.paypal-or-rib'),
                                    'name' => 'infos',
                                    'value' => '',
                                    'required' => true
                                ])
                            </div>
    
                            <div class="panel-footer text-right">
                                <button class="btn btn-primary" type="submit">
                                    {{ trans('app.front.wallet.send') }}
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="panel-body">
                            {{ trans('app.front.wallet.ask-already-exists') }}
                        </div>
                    @endunless
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var $credits = $('#credits');
            var $creditsValue = $('#creditsValue');
            $credits.on('change', function(e) {
                var value = (parseFloat($credits.val()) / 50.0) * 0.72;
                $creditsValue.text(value.toFixed(2));
            });
        });
    </script>
@endpush
