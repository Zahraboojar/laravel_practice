<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleAuthController::class, 'callback']);

Route::get('/profile',[App\Http\Controllers\ProfileConteroller::class, 'index'])->name('profile');
Route::get('/profile/twofactorauth',[App\Http\Controllers\ProfileConteroller::class, 'two_factor_auth'])->name('two_factor_auth');
