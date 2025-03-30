<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Providers\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function cart()
    {
        // dd(Cart::all());
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

    public function quantityChange(Request $request)
    {
        $data = $request->validate([
            'quantity' => 'required',
            'id' => 'required'
        ]);

        if(Cart::has($data['id'])) {
            $product = Cart::get($data['id']);

            if ($data['quantity'] < $product['product']->inventory) {
                Cart::update($data['id'], [
                    'quantity' => $data['quantity']
                ]);

                return response(['status' => 'success']);
            }
        }

        return response(['status' => 'error'], 404);

    }
}
