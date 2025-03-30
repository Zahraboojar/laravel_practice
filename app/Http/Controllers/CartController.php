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

    public function cart2()
    {
        return view('home.cart2');
    }

    public function addToCart(Product $product)
    {
        $class_name = isset($_GET['cart']) ? $_GET['cart'] : 'cart';

        $cart = Cart::instance($class_name);
        if ($cart->has($product)) {
            if ($cart->count($product) < $product->inventory) {
                $cart->update($product, 1);
            }
        } else {
            $cart->put(
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
            'id' => 'required',
            'cart' => 'required'
        ]);

        $cart = Cart::instance($data['cart']);

        if($cart->has($data['id'])) {
            $product = $cart->get($data['id']);

            if ($data['quantity'] < $product['product']->inventory) {
                $cart->update($data['id'], [
                    'quantity' => $data['quantity']
                ]);

                return response(['status' => 'success']);
            }
        }

        return response(['status' => 'error'], 404);

    }

    public function deleteProduct($id)
    {
        $class_name = isset($_GET['cart']) ? $_GET['cart'] : 'cart';
        
        Cart::instance($class_name)->delete($id);

        return back();
    }
}
