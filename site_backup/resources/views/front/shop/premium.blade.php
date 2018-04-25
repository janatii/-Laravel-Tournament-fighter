@extends('front.shop.layout')

@section('section_title')
    @lang('app.front.shop.premium.title')
@endsection

@section('section_content')
    @foreach(config('app.shop.premiums') as $plan => $planDetails)
        @if($subscription && $plan == 'premium_yearly' && $subscription->stripe_plan == 'premium_yearly')
            {{ trans('app.front.shop.errors.you-cant-change-before-end') }}
        @elseif(!$subscription || $plan == 'premium_yearly')
            <div class="shop__product">
                <div class="shop__product__title">
                    {{ trans($planDetails['title']) }}
                </div>
                
                <div class="shop__product__image">
                    <img src="{{ $planDetails['image'] }}" alt="">
                </div>
                
                <div class="shop__product__button">
                    @if(Auth::check())
                        <button class="btn btn-block btn-success buy-button" data-premium-plan="{{ $plan }}" data-description="{{ trans($planDetails['title']) }} {{ LocalizationFormats::formatMoney($planDetails['price']) }} {{ trans('app.front.shop.texts.' . $planDetails['per']) }}">
                            <i class="fa fa-fw fa-cart-plus"></i> {{ LocalizationFormats::formatMoney($planDetails['price']) }} {{ trans('app.front.shop.texts.' . $planDetails['per']) }}
                        </button>
                    @else
                        <button type="button" class="btn btn-success btn-block">
                            {{ LocalizationFormats::formatMoney($planDetails['price']) }} {{ trans('app.front.shop.texts.' . $planDetails['per']) }}
                        </button>
                    @endif
                </div>
            </div>
        @endif
    @endforeach
    
    @if(Auth::check())
        <form id="subscribeForm" action="{{ route_with_subdomain('shop_premium_subscribe') }}" method="post">
            {{ csrf_field() }}
            
            <input type="hidden" name="stripeToken" value="">
            <input type="hidden" name="premium_plan" value="">
            <input type="hidden" name="description" value="">
        </form>
    @endif
@endsection

@section('section_content2')
    <div class="panel panel-default">
        <div class="panel-body">
            {!! trans('app.front.shop.premium.description') !!}
        </div>
    </div>
@endsection

@section('section_content3')
    @if($subscription)
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ trans('app.front.shop.texts.actual-subscription') }}
            </div>
            
            <div class="panel-body current-plan">
                {{ trans('app.front.shop.texts.actual-plan') }} : {{ trans($subscribedPlanInfos['title']) }} {{ LocalizationFormats::formatMoney($subscribedPlanInfos['price']) }} {{ trans('app.front.shop.texts.' . $subscribedPlanInfos['per']) }}<br>
                @if($subscription->onGracePeriod())
                    {{ trans('app.front.shop.texts.until') }} {{ $subscription->ends_at->format(LocalizationFormats::getFormat('date')) }}<br>
                    
                    <form action="{{ route_with_subdomain('shop_premium_resume') }}" method="post">
                        {{ csrf_field() }}
                        <button class="btn btn-success" type="submit">
                            {{ trans('app.front.shop.texts.resume-subscription') }}
                        </button>
                    </form>
                @else
                    <form action="{{ route_with_subdomain('shop_premium_cancel') }}" method="post">
                        {{ csrf_field() }}
                        <button class="btn btn-danger" type="submit">
                            {{ trans('app.front.shop.texts.cancel-subscription') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    @if(Auth::check())
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script>
            var $form = $('#subscribeForm');
            var $buttonClicked = null;
            
            var stripeHandler = StripeCheckout.configure({
                key: '{{ env('STRIPE_KEY') }}',
                name: 'Tournament Fighters',
                image: '/img/default.jpg',
                locale: 'auto',
                currency: 'eur',
                email: '{{ $user->email }}',
                panelLabel: '{{ trans('app.front.shop.texts.subscribe') }}',
                token: function(token) {
                    if ($buttonClicked) {
                        $form.find('input[name="stripeToken"]').val(token.id);
                        $form.find('input[name="premium_plan"]').val($buttonClicked.data('premium-plan'));
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
                });
            });
            
            window.addEventListener('popstate', function() {
                stripeHandler.close();
            });
        </script>
    @endif
@endpush
