<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index(): \Inertia\Response
    {
        $categories = Category::with('products')
            ->where('vendor_id', '=', auth()->user()->id)->get();

        return Inertia::render('Menu/Index', [
            'categories' => $categories,
        ]);
    }

    public function getMenus(Request $request)
    {
        $menus = Menu::with('categories.products')
            ->where('vendor_id', '=', auth()->user()->id)
            ->where('name', 'LIKE', "%{$request->searchString}%")
            ->where('vendor_id', '=', auth()->user()->id)
            ->paginate();

        return response()->json(['success' => $menus, 'count' => count($menus)]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'background_image' => 'required',
            'categories' => 'required',
            'status' => 'required',
        ]);
        if (Menu::whereStatus('active')->whereVendorId(auth()->user()->id)->first() && $request->status == 'active') {
            $validator->errors()->add('status', 'Only one menu can be active at a time.');

            return response()->json(['errors' => $validator->errors()]);
        }
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $path = $request->file('background_image')->store('public/vendor/menu');
        $menu = Menu::firstOrCreate([
            'name' => $request->name,
            'vendor_id' => auth()->user()->id,
        ], [
            'name' => $request->name,
            'vendor_id' => auth()->user()->id,
            'description' => $request->description,
            'background_image' => $path,
            'status' => $request->status,
        ]);
        $menu->categories()->attach($request->categories);

        return response()->json(['success' => 'Menu Created Successfully! ']);
    }

    public function destroy($menuId)
    {
        $menu = Menu::find($menuId);
        $menu->categories()->detach();
        $menu->delete();

        return response()->json(['success' => 'Menu Delete Successfully! ']);
    }
}
