<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Providers\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function cart()
    {
        return view('home.cart');
    }

    public function addToCart(Product $product)
    {
        if (Cart::has($product)) {
            if (Cart::count($product) < $product->inventory) {
                Cart::update($product, 1);
            }
        } else {
            Cart::put(
                [
                    'quantity' => 1,
                    'price' => $product->price
                ],
                $product
            );
        }

        return 'ok';
    }
}
