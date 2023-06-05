<!-- Modal -->
<div class="modal fade" id="productModal-{{$product->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7 col-sm-12 col-xs-12" style="direction: rtl;">
                        <div class="product-details-content quickview-content">
                            <h2 class="text-right mb-4">{{$product->name}}</h2>
                            <div class="product-details-price variation-price">
                                @if($product->quantity_check)
                                    @if($product->sale_check)
                                        <span
                                            class="new">{{ number_format($product->sale_check->sale_price) }}تومان</span>
                                        <span class="old">{{ number_format($product->sale_check->price) }}تومان</span>
                                    @else
                                        <span class="new">{{ number_format($product->price_check->price) }}تومان</span>
                                    @endif
                                @else
                                    <div class="not-in-stock">
                                        <p class="text-white">ناموجود</p>
                                    </div>
                                @endif
                            </div>
                            <div class="pro-details-rating-wrap">
                                <div id="dataReadonlyReview"
                                     data-rating-stars="5"
                                     data-rating-readonly="true"
                                     data-rating-value="{{ceil($product->rates->avg('rate'))}}">
                                </div>
                                <span class="mx-5">|</span>
                                <span>{{ceil($product->rates()->avg('rate'))}} دیدگاه</span>
                            </div>
                            <p class="text-right" style="overflow-wrap: anywhere">
                                {{$product->description}}
                            </p>
                            <div class="pro-details-list text-right">
                                <ul class="text-right">
                                    @foreach($product->attributes()->with('attribute')->get() as $attribute)
                                        <li>- {{$attribute->attribute->name}}:{{$attribute->value}}</li>
                                    @endforeach

                                </ul>
                            </div>
                            <form action="{{route('home.cart.add')}}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$product->id}}">
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
                                            <select name="variation" class="form-control variation-select">
                                                @foreach($product->variations()->where('quantity','>',0)->get() as $variation)
                                                    <option
                                                        value="{{json_encode($variation->only(['id','is_sale','sale_price','price','quantity'])) }}"
                                                        {{ $variationProductSelected->id == $variation->id ? 'selected' : '' }}>
                                                        {{$variation->value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="pro-details-quality">
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box quantity-input" type="text"
                                                   name="qtybutton" value="1" data-max="5"/>

                                        </div>
                                        <div class="pro-details-cart">
                                            <button type="submit">افزودن به سبد خرید</button>
                                        </div>

                                        <div class="pro-details-wishlist">
                                            @auth
                                                @if($product->checkUserWishlist(auth()->id()))
                                                    <a href="{{route('home.wishlist.remove',['product' => $product->id])}}"><i
                                                            class="fa fa-heart" style="color: red"></i></a>
                                                @else
                                                    <a href="{{route('home.wishlist.add',['product' => $product->id])}}"><i
                                                            class="sli sli-heart"></i></a>
                                                @endif
                                            @else
                                                <a href="{{route('home.wishlist.add',['product' => $product->id])}}"><i
                                                        class="sli sli-heart"></i></a>
                                            @endauth
                                        </div>
                                        <div class="pro-details-compare">
                                            <a title="Add To Compare"
                                               href="{{route('home.compare.add',['product' => $product->id])}}"><i
                                                    class="sli sli-refresh"></i></a>
                                        </div>
                                    </div>
                                @else
                                    <div class="not-in-stock">
                                        <p class="text-white">ناموجود</p>
                                    </div>
                                @endif
                            </form>
                            <div class="pro-details-meta">
                                <span>دسته بندی :</span>
                                <ul>

                                    <li><a href="#">{{$product->category->parent->name}}
                                            ,{{$product->category->name}}</a></li>

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

                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="tab-content quickview-big-img">
                            <div id="pro-primary-{{$product->id}}" class="tab-pane fade show active">
                                <img src="{{Storage::url($product->primary_image)}}" alt=""/>
                            </div>
                            @foreach ($product->files as $image)
                                <div id="pro-{{$image->id}}" class="tab-pane fade">
                                    <img src="{{ Storage::url($image->path.'/'.$image->name)}}" alt=""/>
                                </div>
                            @endforeach
                        </div>
                        <!-- Thumbnail Large Image End -->
                        <!-- Thumbnail Image End -->
                        <div class="quickview-wrap mt-15">
                            <div class="quickview-slide-active owl-carousel nav nav-style-2" role="tablist">
                                <a class="active" data-toggle="tab" href="#pro-primary-{{$product->id}}">
                                    <img src="{{Storage::url($product->primary_image)}}" alt=""/>
                                </a>
                                @foreach ($product->files as $image)
                                    <a data-toggle="tab" href="#pro-{{$image->id}}">
                                        <img src="{{ Storage::url($image->path.'/'.$image->name)}}" alt=""/>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->
