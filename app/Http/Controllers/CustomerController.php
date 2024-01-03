<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        $menus = Menu::with('vendor.store')->whereStatus('active')->get();

        return Inertia::render('Customer/Index', [
            'menus' => $menus,
        ]);
    }

    public function showMenu($id)
    {
        $menu = Menu::with('vendor.store')->find($id);
        //        dd($menu->categories);
        $data = [
            'category' => 'categoryName',
            'products' => 'listofproducts',
            'sizes' => '3 sizes each',
            'prices' => '3 prices each',
        ];

        return Inertia::render('Customer/MenuDetail', [
            'menu' => $menu,
        ]);
    }
}
