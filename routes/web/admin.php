<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.index');
});

// Route::get('/users', function () {
//     return view('admin.users');
// });

Route::resource('users', UserController::class);