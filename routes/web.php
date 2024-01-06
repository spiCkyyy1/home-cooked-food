<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return Inertia::render('Welcome');
//})->middleware(['auth', 'checkUserRole'])->name('home');

Route::group(['middleware' => ['role:Vendor']], function () {

    Route::get('/users', function () {
        return Inertia::render('Users/Index');
    })->name('users');

    Route::get('/store/get', [\App\Http\Controllers\VendorController::class, 'get'])->name('store.get');
    Route::post('/store/update', [\App\Http\Controllers\VendorController::class, 'update'])->name('store.update');

    Route::prefix('menu')->group(function () {
        Route::get('/', [\App\Http\Controllers\MenuController::class, 'index'])->name('menu');
        Route::get('/get', [\App\Http\Controllers\MenuController::class, 'getMenus'])->name('menu.get');
        Route::post('/add', [\App\Http\Controllers\MenuController::class, 'store'])->name('menu.add');
        Route::post('/delete/{id}', [\App\Http\Controllers\MenuController::class, 'destroy'])->name('menu.delete');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [\App\Http\Controllers\CategoriesController::class, 'index'])->name('categories');
        Route::get('/get', [\App\Http\Controllers\CategoriesController::class, 'getCategories'])->name('categories.get');
        Route::post('/add', [\App\Http\Controllers\CategoriesController::class, 'store'])->name('categories.add');
        Route::post('delete-category/{id}', [\App\Http\Controllers\CategoriesController::class, 'deleteCategory'])->name('delete.category');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [\App\Http\Controllers\ProductsController::class, 'index'])->name('products');
        Route::get('/get', [\App\Http\Controllers\ProductsController::class, 'getProducts'])->name('products.get');
        Route::post('/add', [\App\Http\Controllers\ProductsController::class, 'store'])->name('products.add');
        Route::post('/delete/{id}', [\App\Http\Controllers\ProductsController::class, 'destroy'])->name('products.delete');
    });
});

Route::group(['middleware' => ['checkUserRole']], function () {
    Route::get('/', [\App\Http\Controllers\CustomerController::class, 'index'])->name('home');
    Route::get('/get-menus', [\App\Http\Controllers\CustomerController::class, 'getMenus'])->name('get.menus');
    Route::get('/get-rating', [\App\Http\Controllers\CustomerController::class, 'getRating'])->name('get.rating');
    Route::get('/menu-details/{id}', [\App\Http\Controllers\CustomerController::class, 'showMenu'])->name('show.menu');
    Route::get('/add-to-cart/{productId}/{quantity}', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/remove-from-cart', [\App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/mark-rating', [\App\Http\Controllers\CustomerController::class, 'markRating'])->name('mark.rating');
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'showCart'])->name('cart.show');
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/session', [\App\Http\Controllers\CheckoutController::class, 'getSession'])->name('session.get');
});

Route::group(['middleware' => ['role:Admin']], function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/role', [\App\Http\Controllers\RoleController::class, 'index'])->name('show.roles');
    Route::get('/get-roles', [\App\Http\Controllers\RoleController::class, 'getRoles'])->name('get.roles');
    Route::post('add-role', [\App\Http\Controllers\RoleController::class, 'addRole'])->name('add.role');
    Route::post('delete-role/{id}', [\App\Http\Controllers\RoleController::class, 'deleteRole'])->name('delete.role');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
