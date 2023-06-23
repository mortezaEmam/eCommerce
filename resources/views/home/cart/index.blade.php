@extends('home.layouts.home')

@section('title')
    صفحه ای خرید
@endsection

@section('content')
<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="{{route('home.index')}}"> صفحه ای اصلی </a>
                </li>
                <li class="active"> سبد خرید</li>
            </ul>
        </div>
    </div>
</div>
<div class="cart-main-area pt-95 pb-100 text-right" style="direction: rtl;">
    <div class="container">
        <h3 class="cart-page-title"> سبد خرید شما </h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                @if($is_empty_cart)
                    <div class="container cart-empty-content">
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center">
                                <i class="sli sli-basket"></i>
                                <h2 class="font-weight-bold my-4">سبد خرید خالی است.</h2>
                                <p class="mb-40">شما هیچ کالایی در سبد خرید خود ندارید.</p>
                                <a href="{{route('home.index')}}"> ادامه خرید </a>
                            </div>
                        </div>
                    </div>
                @else
                    <form action="{{route('home.cart.update')}}" method="post">
                        @csrf
                        @method('put')
                        <div class="table-content table-responsive cart-table-content">
                            <table>
                                <thead>
                                <tr>
                                    <th> تصویر محصول</th>
                                    <th> نام محصول</th>
                                    <th> فی</th>
                                    <th> تعداد</th>
                                    <th> قیمت</th>
                                    <th> عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products_cart as $product)
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="{{route('home.products.show' ,['product' => $product->associatedModel->slug])}}"><img width="100" src="{{asset(Storage::Url($product->associatedModel->primary_image))}}" alt=""></a>
                                        </td>
                                        <td class="product-name"><a href="{{route('home.products.show' ,['product' => $product->associatedModel->slug])}}"> {{$product->associatedModel->name}} </a></td>
                                        <td class="product-price-cart"><span class="amount">
                                            <p class="mb-0" style="font-size: 12px">
                                                {{ \App\Models\Attribute::find($product->attributes->attribute_id)->name }}
                                                :
                                                {{ $product->attributes->value }}
                                            </p>
                                                {{number_format($product->price)}}
                                                تومان
                                            </span>

                                            @if($product->attributes->is_sale)
                                                <p style="font-size: 12px ; color:red">
                                                    {{ $product->attributes->percent_sale }}%
                                                    تخفیف
                                                </p>
                                            @endif
                                        </td>
                                        <td class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" type="text" name="qtybutton[{{$product->id}}]" data-max = "{{$product->attributes->quantity}}" value="{{$product->quantity}}">
                                            </div>
                                        </td>
                                        <td class="product-subtotal">
                                            {{number_format($product->quantity * $product->price)}}
                                            تومان
                                        </td>
                                        <td class="product-remove">
                                            <a href="{{route('home.cart.remove' ,['rowId'=> $product->id])}}"><i class="sli sli-close"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cart-shiping-update-wrapper">
                                    <div class="cart-shiping-update">
                                        <a href="{{route('home.index')}}"> ادامه خرید </a>
                                    </div>
                                    <div class="cart-clear">
                                        <button type="submit"> به روز رسانی سبد خرید</button>
                                        <a href="{{route('home.cart.clear')}}"> پاک کردن سبد خرید </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row justify-content-between">

                        <div class="col-lg-4 col-md-6">
                            <div class="discount-code-wrapper">
                                <div class="title-wrap">
                                    <h4 class="cart-bottom-title section-bg-gray"> کد تخفیف </h4>
                                </div>
                                <div class="discount-code">
                                    <p>کد تخفیف را در باکس پایین وارد کنید </p>
                                    <form action="{{route('home.cart.check_coupon')}}" method="post">
                                        @csrf
                                        <input type="text" required="required" name="code">
                                        <button class="cart-btn-2" type="submit"> ثبت</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">
                            <div class="grand-totall">
                                <div class="title-wrap">
                                    <h4 class="cart-bottom-title section-bg-gary-cart"> مجموع سفارش </h4>
                                </div>
                                <h5>
                                    مبلغ سفارش :
                                    <span>
                                        {{number_format($amount_percent_sale_product + $total_cart)}}
                                        تومان
                                    </span>
                                </h5>
                                @if(number_format($amount_percent_sale_product) > 0)
                                    <h5>
                                        مبلغ تخفیف :
                                        <span style="color: red">
                                        {{number_format($amount_percent_sale_product)}}
                                        تومان
                                    </span>
                                    </h5>
                                @endif
                                @if(session()->has('coupon') )
                                    <h5>
                                        کد تخفیف :
                                        <span style="color: red">
                                        {{number_format(session()->get('coupon.amount'))}}
                                        تومان
                                    </span>
                                    </h5>
                                @endif
                                <div class="total-shipping">
                                    <h5>
                                        هزینه ارسال :
                                        @if($delivery_amount_products > 0)
                                            <span>
                                            {{number_format($delivery_amount_products)}}
                                            تومان
                                            </span>
                                        @else
                                            <span style="color: red">
                                           رایگان
                                           </span>
                                        @endif
                                    </h5>

                                </div>
                                <h4 class="grand-totall-title">
                                    جمع کل:
                                    <span>
                                        {{cartTotalAmount()}}
                                        تومان
                                    </span>
                                </h4>
                                <a href="{{route('home.cart.checkout')}}"> ادامه فرآیند خرید </a>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
