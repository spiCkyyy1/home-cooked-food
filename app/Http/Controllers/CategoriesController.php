<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        return inertia('Category/Index');
    }

    public function getCategories(Request $request)
    {
        $categories = Category::where('name', 'LIKE', "%{$request->searchString}%")
            ->where('vendor_id', '=', auth()->user()->id)->paginate();

        return response()->json(['success' => $categories, 'count' => count($categories)]);
    }

    public function store(Request $request)
    {

        Category::create($request->all() + ['vendor_id' => auth()->user()->id]);

        return response()->json(['success' => 'Category added successfully.']);
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);
        $category->delete();

        return response()->json(['success' => 'Category Deleted Successfully!']);
    }
}
