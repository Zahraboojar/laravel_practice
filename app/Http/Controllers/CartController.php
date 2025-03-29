<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Providers\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Product $product)
    {
        // dd(Cart::has($product));
        if (! Cart::has($product)) {
            Cart::put([
                'quantity' => 1,
                'price' => $product->price
            ], $product);
        }

        Cart::get($product);

    //    return 'ok';

    }
}
