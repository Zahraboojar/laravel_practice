<?php

namespace App\Http\Controllers;

use App\Providers\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Str;

class PaymentController extends Controller
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
            
            $token = config('services.payping.token');
            $resnumber = Str::random();

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ])->post('https://api.payping.ir/v2/pay', [
                'amount' => 1000, // مبلغ به ریال
                'payerName' => auth()->user()->name,
                'payerIdentity' => '09139268351', // ایمیل یا شماره تلفن
                'returnUrl' => route('payment.callback'),
                'description' => 'پرداخت تستی',
                'clientRefId' => $resnumber
            ]);

            $order->payments()->create([
                'price' => $price,
                'resnumber' => $resnumber
            ]);

            $cart->flush();

            if ($response->successful()) {
                $paymentUrl = "https://www.payping.ir/v2/pay/goto/" . $response->json('code');
                return redirect($paymentUrl);
            } else {
                return response()->json($response->json(), 400);
            }
        }
        return 'nothing to pay';
    }

    public function callback(Request $request)
    {
        $token = config('services.payping.token');
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post('https://api.payping.ir/v2/pay/verify', [
            'amount' => 100000, // باید همان مبلغی باشد که در مرحله پرداخت فرستادی
            'refId' => $request->query('refid')
        ]);

        if ($response->successful()) {
            return 'پرداخت با موفقیت تأیید شد. شماره تراکنش: ' . $request->query('refid');
        } else {
            return 'خطا در تأیید پرداخت: ' . $response->body();
        }
    }
}
