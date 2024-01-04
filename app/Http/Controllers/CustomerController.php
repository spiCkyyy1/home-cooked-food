<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        return Inertia::render('Customer/Index');
    }

    public function getMenus(Request $request)
    {
        $menus = Menu::with(['vendor.store' => function($q) use ($request){
//            $request->longitude &&
            $q->when($request->longitude, function($query) use($request){
                $query->where('address', '=', $request->longitude);
//                    ->where('vendor_stores.latitude', 'LIKE', "%".$request->latitude."%");
            });
        }])->whereStatus('active')->paginate();
        return response()->json(['success' => $menus]);
    }

    public function showMenu($id)
    {
        $menu = Menu::with('vendor.store')->find($id);

        return Inertia::render('Customer/MenuDetail', [
            'menu' => $menu,
        ]);
    }
}
