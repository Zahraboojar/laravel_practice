<?php

namespace App\Providers\Cart;

use Illuminate\Database\Eloquent\Model;
use Str;
class CartSevice
{

    protected $cart;
    public function __construct()
    {
        $this->cart = session()->get('cart') ?? collect([]);
    }
    public function put(array $value, $obj = null)
    {
        if(! is_null($obj) && $obj instanceof Model)
        {
            $value = array_merge($value, [
                'id' => Str::random(10),
                'subject_id' => $obj->id,
                'subject_type' => get_class($obj)
            ]);
        } else {
            $value = array_merge($value, [
                'id' => Str::random(10)
            ]);
        }

        $this->cart->put($value['id'], $value);
        session()->put('cart', $this->cart);

        return $this;
    }

    public function has($key)
    {
        if ($key instanceof Model) {
            return ! is_null(
                $this->cart->where('subject_id', $key->id)->where('subject_type', get_class($key))
            );;
        }

        return ! is_null(
            $this->cart->firstWhere('id' , $key)
        );
    }

    public function get($key) {
        $item = $key instanceof Model
            ? $this->cart->where('subject_id', $key->id)->where('subject_type', get_class($key))->first()
            : $this->cart->firstWhere('id', $key);

        return $item;
    }

    public function all()
    {
        return $this->cart;
    }
}