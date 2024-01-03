<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index()
    {
        $categories = Category::where('vendor_id', '=', auth()->user()->id)->get();

        return Inertia::render('Products/Index', [
            'categories' => $categories,
        ]);
    }

    public function getProducts(Request $request)
    {
        $products = Product::where('name', 'LIKE', "%{$request->searchString}%")
            ->where('vendor_id', '=', auth()->user()->id)->paginate();

        return response()->json(['success' => $products, 'count' => count($products)]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'ingredients' => 'required',
            'productDetail.*.price' => 'required|integer',
            'productDetail.*.quantity' => 'required|in:1,2,3',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $product = Product::firstOrCreate([
            'name' => $request->name,
            'vendor_id' => auth()->user()->id,
        ], [
            'name' => $request->name,
            'vendor_id' => auth()->user()->id,
            'ingredients' => $request->ingredients,
            'status' => $request->status,
        ]);
        $product->details()->createMany($request->productDetail);
        $product->categories()->attach($request->category);

        return response()->json(['success' => 'Product Added Successfully! ']);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product->details()->exists()) {
            $product->details()->delete();
        }
        if ($product->categories()->exists()) {
            $product->categories()->detach();
        }
        $product->delete();

        return response()->json(['success' => 'Product Removed Successfully! ']);

    }
}
