<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function checkout()
    {
        return Inertia::render('Checkout/Index');
    }
    public function getSession(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $products = $request->products;
        $amount = $request->amount;
        return $stripe->checkout->sessions->create([
            'success_url' => route('home'),
            'cancel_url' => route('cart.show'),
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => 500, //$request->amount
                        'product_data' => [
                            'name' => 'Cool Stripe checkout',
                        ]
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
        ]);
    }
}
