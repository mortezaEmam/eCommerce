@extends('home.layouts.home')

@section('title')
    صفحه اصلی
@endsection

@section('scripts')
    <script>
        $('.variation-select').on('change', function () {
            let variation = JSON.parse(this.value);
            let variationPriceDiv = $('.variation-price');
            variationPriceDiv.empty();
            if (variation.is_sale) {
                let spanSale = $('<span />', {
                    class: 'new',
                    text: toPersianNum(number_format(variation.sale_price)) + ' تومان'
                });
                let spanPrice = $('<span />', {
                    class: 'old',
                    text: toPersianNum(number_format(variation.price)) + ' تومان'
                });

                variationPriceDiv.append(spanSale);
                variationPriceDiv.append(spanPrice);
            } else {
                let spanPrice = $('<span />', {
                    class: 'new',
                    text: toPersianNum(number_format(variation.price)) + ' تومان'
                });
                variationPriceDiv.append(spanPrice);
            }
            $('.quantity-input').attr('data-max', variation.quantity);
            $('.quantity-input').val(1);
        })

    </script>
@endsection
@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{route('home.index')}}">صفحه ای اصلی</a>
                    </li>
                    <li class="active">فروشگاه</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="product-details-area pt-100 pb-95">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 order-2 order-sm-2 order-md-1" style="direction: rtl;">
                    <div class="product-details-content ml-30">
                        <h2 class="text-right"> {{$product->name}}</h2>
                        <div class="product-details-price variation-price">
                            @if($product->quantity_check)
                                @if($product->sale_check)
                                    <span class="new">{{ number_format($product->sale_check->sale_price) }}تومان</span>
                                    <span class="old">{{ number_format($product->sale_check->price) }}تومان</span>
                                @else
                                    <span class="new"> {{ number_format($product->price_check->price) }}تومان</span>
                                @endif
                            @else
                                <div class="not-in-stock">
                                    <p class="text-white">ناموجود</p>
                                </div>
                            @endif
                        </div>
                        <div class="pro-details-rating-wrap">
                            <div id="dataReadonlyReview" data-rating-stars="5" data-rating-readonly="true"
                                 data-rating-value="{{ceil($product->rates->avg('rate'))}}"></div>
                            <span class="mx-5">|</span>
                            <span>{{$approvedComments->count()}} دیدگاه</span>
                        </div>
                        <p class="text-right">{{$product->description}}</p>
                        <div class="pro-details-list text-right">
                            <ul class="text-right">
                                @foreach($product->attributes()->with('attribute')->get() as $attribute)
                                    <li>- {{$attribute->attribute->name}}:{{$attribute->value}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @if($product->quantity_check)
                            @php
                                if($product->sale_check)
                                  {
                                      $variationProductSelected = $product->sale_check;
                                  }else{
                                      $variationProductSelected = $product->price_check;
                                  }
                            @endphp
                            <div class="pro-details-size-color text-right">
                                <div class="pro-details-size w-50">
                                    <span>{{\App\Models\Attribute::getAttributeId($product)->name}}</span>
                                    <select class="form-control variation-select">
                                        @foreach($product->variations()->where('quantity','>',0)->get() as $variation)
                                            <option
                                                value="{{json_encode($variation->only(['id','is_sale','sale_price','price','quantity'])) }}"{{ $variationProductSelected->id == $variation->id ? 'selected' : '' }}>{{$variation->value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="pro-details-quality">
                                <div class="cart-plus-minus">
                                    <input class="cart-plus-minus-box quantity-input" type="text" name="qtybutton"
                                           value="1" data-max="5"/>
                                </div>
                                <div class="pro-details-cart">
                                    <a href="#">افزودن به سبد خرید</a>
                                </div>
                                <div class="pro-details-wishlist">
                                    <a title="Add To Wishlist" href="#"><i class="sli sli-heart"></i></a>
                                </div>
                                <div class="pro-details-compare">
                                    <a title="Add To Compare" href="#"><i class="sli sli-refresh"></i></a>
                                </div>
                            </div>
                        @else
                            <div class="not-in-stock">
                                <p class="text-white">ناموجود</p>
                            </div>
                        @endif
                        <div class="pro-details-meta">
                            <span>دسته بندی :</span>
                            <ul>
                                <li><a href="#">{{$product->category->parent->name}},{{$product->category->name}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="pro-details-meta">
                            <span>تگ ها :</span>
                            <ul>
                                @foreach($product->tags as $tag)
                                    <li><a href="#">{{$tag->name}}{{$loop->last ? '' : ','}} </a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 order-1 order-sm-1 order-md-2">
                    <div class="product-details-img">
                        <div class="zoompro-border zoompro-span">
                            <img class="zoompro" width="570" height="570"
                                 src="{{Storage::url($product->primary_image)}}"
                                 data-zoom-image="{{Storage::url($product->primary_image)}}" alt=""/>
                        </div>
                        <div id="gallery" class="mt-20 product-dec-slider">
                            <a data-image="{{Storage::url($product->primary_image)}}"
                               data-zoom-image="{{Storage::url($product->primary_image)}}">
                                <img width="90" height="140" src="{{Storage::url($product->primary_image)}}" alt="">
                            </a>
                            @foreach ($product->files as $image)
                                <a data-image="{{ Storage::url($image->path.'/'.$image->name)}}"
                                   data-zoom-image="{{ Storage::url($image->path.'/'.$image->name)}}">
                                    <img width="90" height="140" src="{{ Storage::url($image->path.'/'.$image->name)}}"
                                         alt="">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="description-review-area pb-95">
        <div class="container">
            <div class="row" style="direction: rtl;">
                <div class="col-lg-8 col-md-8">
                    <div class="description-review-wrapper">
                        <div class="description-review-topbar nav">
                            <a class="{{$errors->count() > 0 ? '' : 'active'}}" data-toggle="tab" href="#des-details1">
                                توضیحات </a>
                            <a data-toggle="tab" href="#des-details3"> اطلاعات بیشتر </a>
                            <a class="{{$errors->count() > 0 ? 'active' : ''}}" data-toggle="tab" href="#des-details2">دیدگاه({{$approvedComments->count()}}
                                )</a>
                        </div>
                        <div class="tab-content description-review-bottom">
                            <div id="des-details1" class="tab-pane {{$errors->count() > 0 ? '' : 'active'}}">
                                <div class="product-description-wrapper">
                                    <p class="text-justify">
                                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                                        طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که
                                        لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود
                                        ابزارهای کاربردی می‌باشد.
                                    </p>
                                    <p class="text-justify">
                                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                                        طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که
                                        لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود
                                        ابزارهای کاربردی می‌باشد.
                                    </p>
                                </div>
                            </div>
                            <div id="des-details3" class="tab-pane">
                                <div class="product-anotherinfo-wrapper text-right">
                                    <ul>
                                        <li>
                                            <span> وزن : </span>
                                            400 g
                                        </li>
                                        <li><span> ابعاد : </span>10 x 10 x 15 cm</li>
                                        <li><span> مواد بکار رفته : </span> 60% cotton, 40% polyester</li>
                                        <li><span> اطلاعات دیگر : </span>
                                            لورم ایپسوم متن ساختگی با تولید سادگی
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="des-details2" class="tab-pane {{$errors->count() > 0 ? 'active' : ''}}">
                                <div class="review-wrapper">
                                    @include('home.section.comments.comments_list')
                                </div>
                                @include('home.section.comments.comment_cart')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="pro-dec-banner">
                        <a href="#"><img src="{{asset('images/banners/banner-7.png')}}" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-area pb-70">
        <div class="container">
            <div class="section-title text-center pb-60">
                <h2> محصولات مرتبط </h2>
                <p>
                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                    چاپگرها و متون بلکه روزنامه و مجله
                </p>
            </div>
            <div class="arrivals-wrap scroll-zoom">
                <div class="ht-products product-slider-active owl-carousel">
                    @foreach($products_category as $product)
                        @include('home.front.sections.product',['product'=>$product])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @foreach($products_category as $product)
        @include('home.front.modal.product')
    @endforeach
@endsection
