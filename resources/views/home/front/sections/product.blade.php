<!--Product Start-->
<div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
    <div class="ht-product-inner">
        <div class="ht-product-image-wrap">
            <a href="product-details.html" class="ht-product-image">
                <img src="{{Storage::url($product->primary_image)}}"
                     alt="Universal Product Style"/>
            </a>
            <div class="ht-product-action">
                <ul>
                    <li>
                        <a href="#" data-toggle="modal"
                           data-target="#productModal-{{$product->id}}"><i
                                class="sli sli-magnifier"></i><span
                                class="ht-product-action-tooltip"> مشاهده سریع
                            </span></a>
                    </li>
                    <li>
                        <a href="#"><i class="sli sli-heart"></i><span
                                class="ht-product-action-tooltip"> افزودن به
                              علاقه مندی ها </span></a>
                    </li>
                    <li>
                        <a href="#"><i class="sli sli-refresh"></i><span
                                class="ht-product-action-tooltip"> مقایسه
                            </span></a>
                    </li>
                    <li>
                        <a href="#"><i class="sli sli-bag"></i><span
                                class="ht-product-action-tooltip"> افزودن به سبد
                              خرید </span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ht-product-content">
            <div class="ht-product-content-inner">
                <div class="ht-product-categories">
                    <a href="#">{{$product->category->name}}</a>
                </div>
                <h4 class="ht-product-title text-right">
                    <a href="product-details.html"> {{$product->name}} </a>
                </h4>
                <div class="ht-product-price">
                    @if($product->quantity_check)
                        @if($product->sale_check)
                            <span class="new">
                                                        {{ number_format($product->sale_check->sale_price) }}
                                                        تومان
                                                    </span>
                            <span class="old">
                                                        {{ number_format($product->sale_check->price) }}
                                                        تومان
                                                    </span>
                        @else
                            <span class="new">
                                                        {{ number_format($product->price_check->price) }}
                                                        تومان
                                                    </span>
                        @endif
                    @else
                        <div class="not-in-stock">
                            <p class="text-white">ناموجود</p>
                        </div>
                    @endif
                </div>
                <div class="ht-product-ratting-wrap">
                    <div id="dataReadonlyReview"
                         data-rating-stars="5"
                         data-rating-readonly="true"
                         data-rating-value="{{ceil($product->rates->avg('rate'))}}">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!--Product End-->
