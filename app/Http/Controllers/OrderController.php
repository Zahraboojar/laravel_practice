<?php

namespace App\Http\Controllers;

use App\Providers\Cart\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function payment()
    {
        $class_name = isset($_GET['cart']) ? $_GET['cart'] : 'cart';

        $cart = Cart::instance($class_name);
        $cart_item = $cart->all();
        if ($cart_item->count()) {
            $price = $cart_item->sum(function($cart) {
                return $cart['product']->price * $cart['quantity'];
            });

            $order_items = $cart_item->mapWithKeys(function($cart) {
                return [$cart['product']->id => ['quantity' => $cart['quantity']] ];
            });

            $order = auth()->user()->orders()->create([
                'status' => 'unpaid',
                'price' => $price
            ]);

            $order->products()->attach($order_items);
            return 'ok';
        }
        return 'nothing to pay';
    }
}
