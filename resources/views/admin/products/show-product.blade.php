@extends('admin.layouts.admin')

@section('title')
    show-product
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">محصول : {{$product->name}}</h5>
            </div>
            <hr>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>نام</label>
                    <input class="form-control" value="{{$product->name}}" type="text" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label> نام برند</label>
                    <input class="form-control" value="{{$product->brand->name}}" type="text" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>دسته بندی</label>
                    <input class="form-control" value="{{$product->category->name}}" type="text" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>وضعیت</label>
                    <input class="form-control" value="{{$product->is_active}}" type="text" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label>تگ ها</label>
                    <div class="form-control div-disable">
                        @foreach($product->tags as $tag)
                            {{$tag->name}}{{$loop->last ? '':','}}
                        @endforeach
                    </div>


                </div>


                <div class="form-group col-md-3">
                    <label>تاریخ ایجاد</label>
                    <input class="form-control" value="{{verta($product->created_at)}}" type="text" disabled>
                </div>
                <div class="form-group col-md-12">
                    <label>توضیحات</label>
                    <textarea class="form-control" cols="3" disabled>{{ $product->description }}</textarea>
                </div>
                <div class="form-group col-md-12">
                    <hr>
                    <label>هزینه ارسال :</label>
                </div>
                <div class="form-group col-md-3">
                    <label>هزینه ارسال</label>
                    <input class="form-control" value="{{number_format($product->delivery_amount)}}&nbsp;تومان"
                           type="text" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>هزینه ارسال به ازای محصول اضافی</label>
                    <input class="form-control"
                           value="{{number_format($product->delivery_amount_per_product)}} &nbsp;تومان" type="text"
                           disabled>
                </div>
                <div class="form-group col-md-12">
                    <hr>
                    <label>ویژگی ها :</label>
                </div>
                @foreach($productAttributes as $productAttribute)
                    <div class="form-group col-md-3">
                        <label>{{$productAttribute->attribute->name}}</label>
                        <input class="form-control" value="{{$productAttribute->value}}" type="text" disabled>
                    </div>
                @endforeach
                @foreach ($productVariations as $variation)
                    <div class="col-md-12">
                        <hr>
                        <div class="d-flex">
                            <p class="mb-0"> قیمت و موجودی برای متغیر ( {{ $variation->value }} ) : </p>
                            <p class="mb-0 mr-3">
                                <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse"
                                        data-target="#collapse-{{ $variation->id }}">
                                    نمایش
                                </button>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="collapse mt-2" id="collapse-{{ $variation->id }}">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label> قیمت </label>
                                        <input type="text" disabled class="form-control"
                                               value="{{ $variation->price }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label> تعداد </label>
                                        <input type="text" disabled class="form-control"
                                               value="{{ $variation->quantity }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label> sku </label>
                                        <input type="text" disabled class="form-control" value="{{ $variation->sku }}">
                                    </div>

                                    {{-- Sale Section --}}
                                    <div class="col-md-12">
                                        <p> حراج : </p>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label> قیمت حراجی </label>
                                        <input type="text" value="{{ $variation->sale_price }}" disabled
                                               class="form-control">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label> تاریخ شروع حراجی </label>
                                        <input type="text"
                                               value="{{ $variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_from) }}"
                                               disabled class="form-control">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label> تاریخ پایان حراجی </label>
                                        <input type="text"
                                               value="{{ $variation->date_on_sale_to == null ? null : verta($variation->date_on_sale_to) }}"
                                               disabled class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Images --}}
                <div class="col-md-12">
                    <hr>
                    <p>تصاویر محصول : </p>
                </div>
                <div class="col-md-3">
                    <label>تصویر اصلی</label>
                    <div class="card">
                        <img class="card-img-top"
                             src="{{Storage::url(env('PRODUCT_PRIMARY_IMAGES_UPLOAD_PATH').$product->primary_image)}}"
                             alt="{{$product->name }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <label>سایر تصاویر</label>
                </div>
                @foreach ($images as $image)
                    <div class="col-md-3">
                        <div class="card">
                            <img class="card-img-top"
                                 src="{{ Storage::url($image->path.'/'.$image->name)}}"
                                 alt="{{ $product->name }}" style="height: 300px;width: auto">
                        </div>
                    </div>
                @endforeach
            </div>

            <div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-info mt-5 ">بازگشت</a>
            </div>
        </div>
    </div>

@endsection
