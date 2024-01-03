<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index(): \Inertia\Response
    {
        $data = Product::all();
        $result = [];
        foreach($data as $value)
        {
            $result[] = [
                'name' => $value->name,
                'price' => $value->prices, //$value->product_prices
//                'quantity' => $value->quantities, //$value->product_quantities
//                'categories' => $value->categories
            ];
        }


        return Inertia::render('Dashboard', ['data' => $result]);

    }
}
