<?php

namespace App\Http\Controllers\Front\Shop;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CreditsController extends BaseShopController
{
    public function page()
    {
        $user = Auth::user();
        
        return view('front.shop.credits', compact('user'));
    }

    public function buy(Request $request)
    {
        $user = Auth::user();
        
        $offers = config('app.shop.credits');
    
        $this->validate($request, [
            'stripeToken' => 'required',
            'credits' => 'required|integer|in:' . implode(',', array_keys($offers)),
            'amount' => 'required',
            'description' => 'required',
        ]);
        
        $stripeToken = $request->input('stripeToken');
        $credits = $request->input('credits');
        $amount = $request->input('amount');
        $description = $request->input('description');
        
        $selectedOffer = $offers[$credits];
        
        if ($selectedOffer['price_cents'] != $amount) {
            Log::alert('Error during payment validation (code: 1) => token : ' . $stripeToken . ', credits : ' . $credits . ', amount : ' . $amount . ', description : ' . $description . ', selectedOffer : ' . print_r($selectedOffer, true));
            return back()->with('error', trans('app.global.generic-texts.error-occured'));
        }
        
        try {
            if ($user->hasStripeId()) {
                $customer = \Stripe\Customer::retrieve($user->stripe_id);
            } else {
                $customer = $this->createStripeCustomer($user, $stripeToken);
            }
            
            $user->charge($selectedOffer['price_cents'], [
                'currency' => 'eur',
                'description' => $selectedOffer['stripe_description'],
            ]);
            
            $user->addCredits(null, $credits);
            
            return back()->with('success', trans('app.front.shop.texts.nbcredits-added', ['nbcredits' => $credits]));
        } catch (\Exception $e) {
            return back()->with('error', trans('app.global.generic-texts.error-occured'));
        }
    }
}
