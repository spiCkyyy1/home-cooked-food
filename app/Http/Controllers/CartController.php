<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function showCart()
    {
        $key = 'cart-'.auth()->user()->id;
        $products = Redis::get($key);
        return Inertia::render('Customer/Cart', [
            'cart' => json_decode($products, true),
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $key = 'cart-'.auth()->user()->id;
        $redisCart = Redis::get($key);
        $cart = json_decode($redisCart, true);
        $product = $request->product;
        foreach ($cart as $k => $value)
        {
            if($value['id'] == $product['id'] && $value['quantity'] == $product['quantity'])
            {
                unset($cart[$k]);
            }
        }
        Redis::set($key, json_encode($cart));

        return response()->json(['success' => $cart, 'product' => $request->product]);

    }

    public function addToCart($productId, $quantityId)
    {
        $product = Product::with(['details' => function ($query) use ($quantityId) {
            $query->where('id', '=', $quantityId);
        }])->find($productId);
        $productDetail = ProductDetail::find($quantityId);
        $cart[] = [
            'id' => $productId,
            'name' => $product->name,
            'quantity' => $productDetail->quantity,
            'price' => $productDetail->price,
        ];
        $key = 'cart-'.auth()->user()->id;
        $redisCart = Redis::get($key);

        if (is_null($redisCart)) {
            Redis::set($key, json_encode($cart));
        } else {
            array_splice($cart, 1, 0, json_decode($redisCart));
            Redis::set($key, json_encode($cart));
        }

        return redirect()->route('cart.show');
    }
    public function checkout()
    {
        $intent = auth()->user()->createSetupIntent();

        dd($intent);
    }
}
