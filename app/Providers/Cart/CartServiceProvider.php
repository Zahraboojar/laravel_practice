<?php

namespace App\Providers\Cart;

use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('cart', function () {
            return new CartSevice();
        });
    }
}