<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.index');
});

Route::resource('users', UserController::class);
Route::resource('products', ProductController::class)->except('show');

Route::get('/comments/unapproved', [CommentController::class, 'unapproved'])->name('comments.unapproved');
Route::resource('comments', CommentController::class)->only(['destroy', 'index', 'update']);

Route::resource('categories', CategoryController::class);