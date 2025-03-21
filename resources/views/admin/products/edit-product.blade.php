@extends('admin.layouts.admin')

@section('title')
    edit product
@endsection

@section('scripts')
    <script>
        $('#brandSelect').selectpicker({
            'title': 'انتخاب برند'
        });
        $('#tagsSelect').selectpicker({
            'title': 'انتخاب تگ ها'
        });
        let variations = @json($productVariations);
        variations.forEach(variation => {
            $(`#variationDateOnSaleFrom-${variation.id}`).azPersianDateTimePicker({
                targetTextSelector:$(`#variationInputDateOnSaleFrom-${variation.id}`) ,
                englishNumber: true,
                enableTimePicker: true,
                textFormat: 'yyyy-MM-dd HH:mm:ss',
            });
            $(`#variationDateOnSaleTo-${variation.id}`).azPersianDateTimePicker({
                targetTextSelector:$(`#variationInputDateOnSaleTo-${variation.id}`),
                englishNumber: true,
                enableTimePicker: true,
                textFormat: 'yyyy-MM-dd HH:mm:ss',
            });
        });

    </script>
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش محصول</h5>
            </div>
            <hr>

            @include('admin.sections.errors')

            <form action="{{ route('admin.products.update',['product' => $product->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{$product->name}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="brandSelect">برند</label>
                        <select class="form-control" id="brandSelect" name="brand_id">
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{$brand->id == $product->brand->id ? 'selected' : ''}}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" {{$product->getRaworiginal('is_active') ? 'selected':''}} >فعال</option>
                            <option value="0" {{!$product->getRaworiginal('is_active') ? 'selected':''}}>غیرفعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="tagsSelect">تگ ها</label>
                        <select id="tagsSelect" name="tag_ids[]" class="form-control" multiple
                                data-live-search="true">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" {{in_array($tag->id , $productTagIds) ? 'selected' : ''}}>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description"
                                  name="description">{{$product->description}}</textarea>
                    </div>
                {{-- Delivery Section --}}
                <div class="col-md-12">
                    <hr>
                    <p>هزینه ارسال : </p>
                </div>

                <div class="form-group col-md-3">
                    <label for="delivery_amount">هزینه ارسال</label>
                    <input class="form-control" id="delivery_amount" name="delivery_amount" type="text" value="{{ $product->delivery_amount }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="delivery_amount_per_product">هزینه ارسال به ازای محصول اضافی</label>
                    <input class="form-control" id="delivery_amount_per_product" name="delivery_amount_per_product" type="text" value="{{ $product->delivery_amount_per_product }}">
                </div>
                    <div class="form-group col-md-12">
                        <hr>
                        <label>ویژگی ها :</label>
                    </div>
                    @foreach($productAttributes as $key => $productAttribute)
                        <div class="form-group col-md-3">
                            <label>{{$productAttribute->attribute->name}}</label>
                            <input class="form-control" value="{{$productAttribute->value}}" type="text" name="Attribute_value[{{$productAttribute->id}}]">
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
                                            <input type="text" name="variation_values[{{$variation->id}}][price]" class="form-control"
                                                   value="{{ $variation->price }}">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> تعداد </label>
                                            <input type="text" name="variation_values[{{$variation->id}}][quantity]" class="form-control"
                                                   value="{{ $variation->quantity }}">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> sku </label>
                                            <input type="text" name="variation_values[{{$variation->id}}][sku]" class="form-control" value="{{ $variation->sku }}">
                                        </div>

                                        {{-- Sale Section --}}
                                        <div class="col-md-12">
                                            <p> حراج : </p>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> قیمت حراجی </label>
                                            <input type="text" name="variation_values[{{ $variation->id }}][sale_price]"
                                                   value="{{ $variation->sale_price }}" class="form-control">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> تاریخ شروع حراجی </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend order-2">
                                                    <span class="input-group-text" id="variationDateOnSaleFrom-{{$variation->id}}">
                                                        <i class="fas fa-clock"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" id="variationInputDateOnSaleFrom-{{$variation->id}}"
                                                       name="variation_values[{{ $variation->id }}][date_on_sale_from]"
                                                       value="{{ $variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_from) }}">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> تاریخ پایان حراجی </label>

                                            <div class="input-group">
                                                <div class="input-group-prepend order-2">
                                                    <span class="input-group-text" id="variationDateOnSaleTo-{{ $variation->id }}">
                                                        <i class="fas fa-clock"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" id="variationInputDateOnSaleTo-{{ $variation->id }}"
                                                       name="variation_values[{{ $variation->id }}][date_on_sale_to]"
                                                       value="{{ $variation->date_on_sale_to == null ? null : verta($variation->date_on_sale_to) }}">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
