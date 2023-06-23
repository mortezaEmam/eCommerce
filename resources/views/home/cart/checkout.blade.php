@extends('home.layouts.home')

@section('title')
    صفحه ای خرید
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#province-id').on('change', function () {
                var idProvince = this.value;
                $("#city-id").html('');
                $.ajax({
                    url: "{{url('provinces/get-cities')}}",
                    type: "POST",
                    data: {
                        province_id: idProvince,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#city-id').html('<option value=""> شهر را انتخاب کنید </option>');
                        $.each(result.cities, function (key, value) {
                            $("#city-id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
@endsection
@section('content')
    <!-- compare main wrapper start -->
    <div class="checkout-main-area pt-70 pb-70 text-right" style="direction: rtl;">
        <div class="container">
            @if (!session()->has('coupon'))
                <div class="customer-zone mb-20">
                    <p class="cart-page-title">
                        کد تخفیف دارید؟
                        <a class="checkout-click3" href="#"> میتوانید با کلیک در این قسمت کد خود را اعمال کنید </a>
                    </p>
                    <div class="checkout-login-info3">
                        <form action="{{route('home.cart.check_coupon')}}" method="post">
                            @csrf
                            <input type="text" required="required" name="code" placeholder="کد تخفیف">
                            <input type="submit" value="اعمال کد تخفیف">
                        </form>
                    </div>
                </div>
            @endif
            <div class="checkout-wrap pt-30">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="billing-info-wrap mr-50">
                            <h3> آدرس تحویل سفارش </h3>
                            <div class="row">
                                <p>
                                    برای مدیریت آدرس ها می توانید به پروفایل خود مراجعه فرمایید,<br>لطفا در وارد کردن
                                    آدرس دقت لازم بفرمایید
                                </p>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info tax-select mb-20">
                                        <label> انتخاب آدرس تحویل سفارش <abbr class="required" title="required">*</abbr></label>

                                        <select class="email s-email s-wid">
                                            @foreach($addresses as $address)
                                                <option value="{{$address->id}}"> {{$address->title}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 pt-30">
                                    <button class="collapse-address-create" type="submit"> ایجاد آدرس جدید</button>
                                </div>
                                <div class="col-lg-12">
                                    <div class="collapse-address-create-content"
                                         style="{{ count($errors->addressStore) > 0 ? 'display:block' : '' }}">
                                        <form action="{{route('home.users_profile.address_users_store')}}"
                                              method="post">
                                            @csrf

                                            <div class="row">

                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        عنوان
                                                    </label>
                                                    <input type="text" name="title" value="{{old('title')}}">
                                                    @error('title', 'addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        شماره تماس
                                                    </label>
                                                    <input type="text" name="phone" value="{{old('phone')}}">
                                                    @error('phone', 'addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label for="province_id">
                                                        استان
                                                    </label>
                                                    <select id="province-id" class="email s-email s-wid"
                                                            name="province_id">
                                                        <option value="" disabled selected>استان را انتخاب کنید</option>
                                                        @foreach($provinces as $province)
                                                            <option value="{{$province->id}}"
                                                                    @if(old('province_id') == $province->id) selected @endif>{{$province->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('province_id', 'addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label for="city_id">
                                                        شهر
                                                    </label>
                                                    <select class="email s-email s-wid" name="city_id" id="city-id">
                                                    </select>
                                                    @error('city_id', 'addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        آدرس
                                                    </label>
                                                    <input type="text" name="address" value="{{old('address')}}">
                                                    @error('address', 'addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        کد پستی
                                                    </label>
                                                    <input type="text" name="postal_code"
                                                           value="{{old('postal_code')}}">
                                                    @error('postal_code', 'addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class=" col-lg-12 col-md-12">
                                                    <button class="cart-btn-2" type="submit"> ثبت آدرس
                                                    </button>
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="your-order-area">
                            <h3> سفارش شما </h3>
                            <div class="your-order-wrap gray-bg-4">
                                <div class="your-order-info-wrap">
                                    <div class="your-order-info">
                                        <ul>
                                            <li> محصول <span> جمع </span></li>
                                        </ul>
                                    </div>
                                    <div class="your-order-middle">
                                        <ul>
                                            @foreach ($products_cart as $item)
                                                <li class="d-flex justify-content-between">
                                                    <div>
                                                        {{ $item->name }}
                                                        -
                                                        {{ $item->quantity }}
                                                        <p class="mb-0" style="font-size: 12px; color:red">
                                                            {{ \App\Models\Attribute::find($item->attributes->attribute_id)->name }}
                                                            :
                                                            {{ $item->attributes->value }}
                                                        </p>
                                                    </div>
                                                    <span>
                                                            {{ number_format($item->price) }}
                                                            تومان
                                                            @if ($item->attributes->is_sale)
                                                            <p style="font-size: 12px ; color:red">
                                                                    {{ $item->attributes->percent_sale }}%
                                                                    تخفیف
                                                                </p>
                                                        @endif
                                                        </span>

                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="your-order-info order-subtotal">
                                        <ul>
                                            <li>مبلغ<span>{{number_format( $total_cart + $amount_percent_sale_product )}}تومان</span>
                                            </li>
                                        </ul>
                                    </div>
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
                                    <div class="your-order-info order-shipping">
                                        <ul>
                                            <li> هزینه ارسال
                                                @if($delivery_amount_products > 0)
                                                    <span>{{number_format($delivery_amount_products)}}تومان</span>
                                                @else
                                                    <span style="color: red">رایگان</span>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="your-order-info order-total">
                                        <ul>
                                            <li>جمع کل
                                                <span>{{cartTotalAmount()}}تومان</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="payment-method">
                                    <div class="pay-top sin-payment">
                                        <input id="zarinpal" class="input-radio" type="radio" value="zarinpal"
                                               checked="checked" name="payment_method">
                                        <label for="zarinpal"> درگاه پرداخت زرین پال </label>
                                        <div class="payment-box payment_method_bacs">
                                            <p>
                                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده
                                                از طراحان گرافیک است.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="pay-top sin-payment">
                                        <input id="pay" class="input-radio" type="radio" value="pay"
                                               name="payment_method">
                                        <label for="pay">درگاه پرداخت پی</label>
                                        <div class="payment-box payment_method_bacs">
                                            <p>
                                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده
                                                از طراحان گرافیک است.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="Place-order mt-40">
                                <button type="submit">ثبت سفارش</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection
