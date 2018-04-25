@extends('front.shop.layout')

@section('section_title')
    @lang('app.front.shop.credits.title')
@endsection

@section('section_content')
    @foreach(config('app.shop.credits') as $nbCredits => $offer)
        <div class="shop__product">
            <div class="shop__product__title">
                {{ trans($offer['title']) }}
            </div>
            
            <div class="shop__product__image">
                <img src="{{ $offer['image'] }}" alt="">
            </div>
            
            <div class="shop__product__button">
                @if(Auth::check())
                    <button class="btn btn-block btn-success buy-button" data-credits="{{ $nbCredits }}" data-amount="{{ $offer['price_cents'] }}" data-description="{{ trans($offer['title']) }}">
                        <i class="fa fa-fw fa-cart-plus"></i> {{ trans('app.front.shop.texts.buy-for', ['price' => LocalizationFormats::formatMoney($offer['price'])]) }}
                    </button>
                    
                    <form id="buyForm" action="{{ route_with_subdomain('shop_credits_buy') }}" method="post">
                        {{ csrf_field() }}
                        
                        <input type="hidden" name="stripeToken" value="">
                        <input type="hidden" name="credits" value="">
                        <input type="hidden" name="amount" value="">
                        <input type="hidden" name="description" value="">
                    </form>
                @else
                    <button type="button" class="btn btn-success btn-block">
                        {{ LocalizationFormats::formatMoney($offer['price']) }}
                    </button>
                @endif
            </div>
        </div>
    @endforeach
@endsection

@section('section_content2')
    <div class="panel panel-default">
        <div class="panel-body">
            {!! trans('app.front.shop.credits.description') !!}
        </div>
    </div>
@endsection

@push('scripts')
    @if(Auth::check())
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script>
            var $form = $('#buyForm');
            var $buttonClicked = null;
            
            var stripeHandler = StripeCheckout.configure({
                key: '{{ env('STRIPE_KEY') }}',
                name: 'Tournament Fighters',
                image: '/img/default.jpg',
                locale: 'auto',
                currency: 'eur',
                email: '{{ $user->email }}',
                token: function(token) {
                    if ($buttonClicked) {
                        $form.find('input[name="stripeToken"]').val(token.id);
                        $form.find('input[name="credits"]').val($buttonClicked.data('credits'));
                        $form.find('input[name="amount"]').val($buttonClicked.data('amount'));
                        $form.find('input[name="description"]').val($buttonClicked.data('description'));
                        $form[0].submit();
                    }
                }
            });
            
            $('.buy-button').click(function(e) {
                e.preventDefault();
                
                var $this = $(this);
                $buttonClicked = $this;
                
                stripeHandler.open({
                    description: $this.data('description'),
                    amount: $this.data('amount'),
                });
            });
            
            window.addEventListener('popstate', function() {
                stripeHandler.close();
            });
        </script>
    @endif
@endpush