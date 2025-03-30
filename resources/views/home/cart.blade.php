@extends('layouts.app')

@section('script')
<script>
        function changeQuantity(event, id , cartName = 'default') {
            //
            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type' : 'application/json'
                }
            })
            //
            $.ajax({
                type : 'POST',
                url : '/cart/quantity/change',
                data : JSON.stringify({
                    id : id ,
                    quantity : event.target.value,
                    // cart : cartName,
                    _method : 'patch'
                }),
                success : function(res) {
                    location.reload();
                }
            });
        }

    </script>

@endsection
@section('content')
    <div class="container px-3 my-5 clearfix">
        <!-- Shopping cart table -->
        <div class="card">
            <div class="card-header">
                <h2>سبد خرید</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered m-0">
                        <thead>
                        <tr>
                            <!-- Set columns width -->
                            <th class="text-center py-3 px-4" style="min-width: 400px;">نام محصول</th>
                            <th class="text-right py-3 px-4" style="width: 150px;">قیمت واحد</th>
                            <th class="text-center py-3 px-4" style="width: 120px;">تعداد</th>
                            <th class="text-right py-3 px-4" style="width: 150px;">قیمت نهایی</th>
                            <th class="text-center align-middle py-3 px-0" style="width: 40px;"><a href="#" class="shop-tooltip float-none text-light" title="" data-original-title="Clear cart"><i class="ino ion-md-trash"></i></a></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach (App\Providers\Cart\Cart::all() as $cart)
                                @if (isset($cart['product']))
                                    <tr>
                                        <td class="p-4">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <a href="#" class="d-block text-dark">{{ $cart['product']->title }}</a>
                                                    <small>
                                                        @if ($cart['product']->attributes)
                                                            @foreach ($cart['product']->attributes->take(3) as $attribute)
                                                                <span class="text-muted">{{ $attribute->name }}: </span> 
                                                                    {{ $attribute->pivot->value->value}}
                                                            @endforeach 
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4">{{ $cart['product']->price }} تومان</td>
                                        <td class="align-middle p-4">
                                            <select onchange="changeQuantity(event, '{{ $cart['id'] }}' , 'cart-roocket')" name="" class="form-control text-center">
                                                @foreach (range(1, $cart['product']->inventory) as $item)
                                                    <option value="{{ $item }}" {{ $cart['quantity'] == $item ? 'selected' : ''}}>{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4">تومان {{ $cart['product']->price* $cart['quantity'] }}</td>
                                        <form method="post" action="{{ route('cart.delete.item', $cart['id']) }}" id="delete_cart_{{ $cart['id'] }}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        <td class="text-center align-middle px-0"><a onclick="event.preventDefault();document.getElementById('delete_cart_{{ $cart['id'] }}').submit()" class="shop-tooltip close float-none text-danger" title="" data-original-title="Remove">×</a></td>
                                    </tr>
                                @endif
                            @endforeach

                        

                        </tbody>
                    </table>
                </div>
                <!-- / Shopping cart table -->
                <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
                    <div class="mt-4"></div>
                    <div class="d-flex">
{{--                        <div class="text-right mt-4 mr-5">--}}
{{--                            <label class="text-muted font-weight-normal m-0">Discount</label>--}}
{{--                            <div class="text-large"><strong>$20</strong></div>--}}
{{--                        </div>--}}
                        <div class="text-right mt-4">
                            <label class="text-muted font-weight-normal m-0">قیمت کل</label>
                            <div class="text-large"><strong> {{ App\Providers\Cart\Cart::all()->sum(function ($cart) {
                            return $cart['product']->price * $cart['quantity'];
                            }) }} تومان</strong></div>
                        </div>
                    </div>
                </div>

                <div class="float-left">
                    <button type="button" class="btn btn-lg btn-primary mt-2">پرداخت</button>
                </div>

            </div>
        </div>
    </div>
@endsection
