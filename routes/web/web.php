<?php

use App\Http\Controllers\Auth\AuthTokenController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileConteroller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // auth()->loginUsingId(1);

    // $user = User::find(1);
    // dd (Gate::allows('user_edit', $user));
    
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::get('/auth/token', [AuthTokenController::class, 'getToken'])->name('2fa.token');
Route::post('/auth/token', [AuthTokenController::class, 'postToken']);

Route::middleware('auth')->group(function() {
    Route::get('/profile',[ProfileConteroller::class, 'index'])->name('profile');
    Route::get('/profile/twofactorauth',[ProfileConteroller::class, 'two_factor_auth'])->name('two_factor_auth');
    Route::post('/profile/twofactorauthrequest',[ProfileConteroller::class, 'two_factor_auth_request'])->name('two_factor_auth_request');

    Route::get('/profile/twofactorauth/phone',[ProfileConteroller::class, 'get_Phone_Verify'])->name('phone_verify');
    Route::post('/profile/twofactorauth/phone',[ProfileConteroller::class, 'post_Phone_Verify']);
});

Route::get('products' , [ProductController::class, 'index']);
Route::get('products/{product}' , [ProductController::class, 'single']);
Route::post('comments' , [HomeController::class, 'comment'])->name('send.comment');

Route::post('cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('cart', [CartController::class, 'cart']);
Route::get('cart2', [CartController::class, 'cart2']);

Route::patch('/cart/quantity/change', [CartController::class, 'quantityChange']);
Route::delete('/cart/delete/{cart}', [CartController::class, 'deleteProduct'])->name('cart.delete.item');

Route::post('payment', [PaymentController::class, 'payment'])->middleware('auth');
Route::get('payment/callback', [PaymentController::class, 'callback'])->middleware('auth')->name('payment.callback');