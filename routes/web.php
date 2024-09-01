<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Mail;

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

Route::get('/', function () {
    return view('home');
});

Auth::routes(['verify' => 'true']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/merchant/dashboard', [MerchantController::class, 'dashboard'])->name('merchant.dashboard');
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
});



// Route umum
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

// Route untuk merchant dengan middleware
Route::group(['middleware' => ['auth', 'role:merchant']], function () {
    Route::get('/merchant/dashboard', [MerchantController::class, 'dashboard'])->name('merchant.dashboard');
    Route::get('/merchant/profile/edit', [MerchantController::class, 'editProfile'])->name('merchant.profile.edit');
    Route::post('/merchant/profile/update', [MerchantController::class, 'updateProfile'])->name('merchant.profile.update');

    Route::get('/merchant/edit-profile', [MerchantController::class, 'editProfile'])->name('merchant.edit-profile');
    Route::put('/merchant/update-profile', [MerchantController::class, 'updateProfile'])->name('merchant.update-profile');

    // Rute untuk menambah menu baru
    Route::get('/merchant/menu/create', [MerchantController::class, 'createMenu'])->name('merchant.menu.create');
    Route::post('/merchant/menu', [MerchantController::class, 'storeMenu'])->name('merchant.menu.store');

    // Rute untuk mengedit menu
    Route::get('/merchant/menu/{menu}/edit', [MerchantController::class, 'editMenu'])->name('merchant.menu.edit');
    Route::post('/merchant/menu/{menu}/update', [MerchantController::class, 'updateMenu'])->name('merchant.menu.update');

    // Rute untuk menghapus menu
    Route::delete('/merchant/menu/{menu}/delete', [MerchantController::class, 'deleteMenu'])->name('merchant.menu.delete');

    // Rute untuk melihat daftar pesanan
    Route::get('/merchant/orders', [MerchantController::class, 'orderList'])->name('merchant.orders');
    Route::get('/merchant/orders/{order}', [MerchantController::class, 'orderDetails'])->name('merchant.order.details');
    Route::post('/merchant/orders/{order}/deliver', [MerchantController::class, 'deliverOrder'])->name('merchant.order.deliver');
});

// Route untuk customer dengan middleware
Route::group(['middleware' => ['auth', 'role:customer']], function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/search', [CustomerController::class, 'searchCatering'])->name('customer.search');

    Route::get('/customer/edit-profile', [CustomerController::class, 'editProfile'])->name('customer.edit-profile');
    Route::put('/customer/update-profile', [CustomerController::class, 'updateProfile'])->name('customer.update-profile');
    // Order Routes
    Route::get('/customer/order/create/{menu_id}', [CustomerController::class, 'createOrder'])->name('customer.order.create');
    Route::post('/customer/order/store', [CustomerController::class, 'storeOrder'])->name('customer.order.store');

    // Invoice Route
    Route::get('/invoice/{id}', [CustomerController::class, 'showInvoice'])->name('customer.invoice');

    // Order Details
    Route::get('/customer/orders/{order}', [CustomerController::class, 'orderDetails'])->name('customer.order.details');

    Route::get('/customer/orders', [CustomerController::class, 'viewOrders'])->name('customer.order.list');
    Route::post('/checkout/{order}', [OrderController::class, 'checkout'])->name('customer.order.checkout');
    Route::post('/order/complete/{order}', [OrderController::class, 'complete'])->name('customer.order.complete');
    Route::delete('/customer/order/{order}', [OrderController::class, 'destroy'])->name('customer.order.destroy');
    Route::post('/customer/orders/{order}/confirm', [CustomerController::class, 'confirmOrder'])->name('customer.order.confirm');

});
