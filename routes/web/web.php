<?php

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    auth()->loginUsingId(1);

    $user = User::find(2);
    dd (Gate::allows('user_edit', $user));
    // return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleAuthController::class, 'callback']);

Route::get('/auth/token', [App\Http\Controllers\Auth\AuthTokenController::class, 'getToken'])->name('2fa.token');
Route::post('/auth/token', [App\Http\Controllers\Auth\AuthTokenController::class, 'postToken']);

Route::middleware('auth')->group(function() {
    Route::get('/profile',[App\Http\Controllers\ProfileConteroller::class, 'index'])->name('profile');
    Route::get('/profile/twofactorauth',[App\Http\Controllers\ProfileConteroller::class, 'two_factor_auth'])->name('two_factor_auth');
    Route::post('/profile/twofactorauthrequest',[App\Http\Controllers\ProfileConteroller::class, 'two_factor_auth_request'])->name('two_factor_auth_request');

    Route::get('/profile/twofactorauth/phone',[App\Http\Controllers\ProfileConteroller::class, 'get_Phone_Verify'])->name('phone_verify');
    Route::post('/profile/twofactorauth/phone',[App\Http\Controllers\ProfileConteroller::class, 'post_Phone_Verify']);
});