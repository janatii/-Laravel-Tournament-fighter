<?php

namespace App\Http\Controllers\Front\Shop;

use App\Http\Controllers\Controller;
use App\Models\User;

class BaseShopController extends Controller
{
    /**
     * @param User $user
     * @param string $stripeToken
     *
     * @return \Stripe\Customer
     */
    protected function createStripeCustomer(User $user, string $stripeToken): \Stripe\Customer
    {
        $customer = \Stripe\Customer::create(array(
            "description" => $user->email,
            "source" => $stripeToken
        ));
        
        $user->stripe_id = $customer->id;
        $user->save();
 
        return $customer;
    }
}
