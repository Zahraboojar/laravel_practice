<?php


namespace App\Providers\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CartSevice
{
    protected $cart;

    public function __construct()
    {
        $this->cart = session()->get('cart') ?? collect([]);
    }

    public function put(array $value , $obj = null)
    {
        if(! is_null($obj) && $obj instanceof Model) {
            $value = array_merge($value , [
               'id' => Str::random(10),
                'subject_id' => $obj->id,
                'subject_type' => get_class($obj)
            ]);
        } elseif (! isset($value['id'])) {
            $value = array_merge($value , [
                'id' => Str::random(10)
            ]);
        }

        $this->cart->put($value['id'] , $value);
        session()->put('cart', $this->cart);

        return $this;
    }

    public function has($key)
    {
        if($key instanceof Model) {
            return ! is_null(
                $this->cart->where('subject_id' , $key->id)->where('subject_type' , get_class($key))->first()
            );
        }

        return ! is_null(
            $this->cart->firstWhere('id' , $key)
        );
    }

    public function get($key, $withRelationShip = true)
    {
        $item = $key instanceof Model
                    ? $this->cart->where('subject_id' , $key->id)->where('subject_type' , get_class($key))->first()
                    : $this->cart->firstWhere('id' , $key);

        return $withRelationShip ? $this->withRelationshipIfExist($item) : $item;
    }

    public function all()
    {
        $cart = $this->cart;
        $cart = $cart->map(function($item) {
            return $this->withRelationshipIfExist($item);
        });

        return $cart;
    }

    public function update($key, $option)
    {
        $item = collect($this->get($key, false));

        if (is_numeric($option)) {
            $item = $item->merge([
                'quantity' => $item['quantity'] + $option
            ]);
        }

        if(is_array($option)) {
            $item = $item->merge($option);
        }

        $this->put($item->toArray());
    }

    public function delete($key)
    {
        if(Cart::has($key)) {
            $this->cart = $this->cart->filter(function($item) use ($key) {
                if ($key instanceof Model) {
                    return ($item['subject_id'] === $key['id'] && $item['subject_type'] === get_class($key));
                }

                return $key != $item['id'];
            });

            session()->put('cart', $this->cart);

            return true;
        }

        return false;
    }

    public function count($key)
    {
        if (! $this->has($key)) return 0;

        return $this->get($key)['quantity'];
    }

    protected function withRelationshipIfExist($item)
    {
        if(isset( $item['subject_id'] ) && isset($item['subject_type']) ) {
            $class = $item['subject_type'];
            $subject = (new $class())->find( $item['subject_id'] );

            $item[strtolower(class_basename($class))] = $subject;

            unset($item['subject_id']);
            unset($item['subject_type']);

            return $item;
        }


        return $item;
    }
}
