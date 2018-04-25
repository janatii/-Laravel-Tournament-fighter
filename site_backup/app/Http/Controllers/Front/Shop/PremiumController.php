<?php

namespace App\Http\Controllers\Front\Shop;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PremiumController extends BaseShopController
{
    public function page()
    {
        $user = Auth::user();
    
        $subscription = null;
        if ($user) {
            $subscription = $user->subscription('premium');
            if ($subscription && $subscription->valid()) {
                $subscribedPlanInfos = config('app.shop.premiums')[$subscription->stripe_plan];
            } else {
                $subscription = null;
            }
        }
        
        return view('front.shop.premium', compact('user', 'subscription', 'subscribedPlanInfos'));
    }

    public function subscribe(Request $request)
    {
        $user = Auth::user();
        
        $plans = config('app.shop.premiums');
    
        $this->validate($request, [
            'stripeToken' => 'required',
            'premium_plan' => 'required|in:' . implode(',', array_keys($plans)),
            'description' => 'required',
        ]);
        
        $stripeToken = $request->input('stripeToken');
        $premiumPlan = $request->input('premium_plan');
        $description = $request->input('description');
        
        try {
            if ($user->hasStripeId()) {
                $customer = \Stripe\Customer::retrieve($user->stripe_id);
            } else {
                $customer = $this->createStripeCustomer($user, $stripeToken);
            }
            
            if ($user->subscribed('premium')) {
                if ($user->subscribedToPlan($premiumPlan, 'premium')) {
                    return back()->with('error', trans('app.front.shop.errors.its-already-your-plan'));
                } elseif ($premiumPlan == 'premium_monthly') {
                    return back()->with('error', trans('app.front.shop.errors.you-cant-change-for-monthly'));
                }
                $user->subscription('premium')->swap($premiumPlan);
                
                return back()->with('success', trans('app.front.shop.texts.premium-modified'));
            } else {
                $user->newSubscription('premium', $premiumPlan)->create($stripeToken, [
                    'tnf_id' => $user->id,
                    'tnf_email' => $user->email,
                ]);
                
                return back()->with('success', trans('app.front.shop.texts.premium-subscribed'));
            }
        } catch (\Exception $e) {
            return back()->with('error', trans('app.global.generic-texts.error-occured'));
        }
    }
    
    public function cancel(Request $request)
    {
        $user = Auth::user();
        
        try {
            if ($user->subscribed('premium')) {
                $subscription = $user->subscription('premium');
                if ($subscription->valid()) {
                    $subscription->cancel();
                    
                    return back()->with('success', trans('app.front.shop.texts.premium-cancelled'));
                }
            }
            return back()->with('error', trans('app.global.generic-texts.error-occured'));
        } catch (\Exception $e) {
            return back()->with('error', trans('app.global.generic-texts.error-occured'));
        }
    }
    
    public function resume(Request $request)
    {
        $user = Auth::user();
        
        try {
            if ($user->subscribed('premium')) {
                $subscription = $user->subscription('premium');
                if ($subscription->onGracePeriod()) {
                    $subscription->resume();
                    
                    return back()->with('success', trans('app.front.shop.texts.premium-resumed'));
                }
            }
            return back()->with('error', trans('app.global.generic-texts.error-occured'));
        } catch (\Exception $e) {
            return back()->with('error', trans('app.global.generic-texts.error-occured'));
        }
    }
}
