<?php

namespace App\Providers\Cart;

use Illuminate\Support\Facades\Facade;

class Cart extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'cart';
    }
}