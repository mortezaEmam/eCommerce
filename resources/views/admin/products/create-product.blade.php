@extends('admin.layouts.admin')

@section('title')
    create product
@endsection

@section('scripts')
    <script>
        $('#brandSelect').selectpicker({
            'title': 'انتخاب برند'
        });
        $('#tagsSelect').selectpicker({
            'title': 'انتخاب تگ ها'
        });

        // Show File Name
        $('#primary_image').change(function () {
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });
        $('#images').change(function () {
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });

        $('#categorySelect').selectpicker({
            'title': 'انتخاب دسته بندی'
        });

        $('#attributesContainer').hide();
        // category && attributes Select
        $('#categorySelect').on('changed.bs.select', function () {
            let categoryId = $(this).val();
            $.get(`{{ url('/admin-panel/management/category-attributes/${categoryId}') }}`, function (response, status) {

                if (status == 'success') {

                    $('#attributesContainer').fadeIn();

                    // Empty Attribute Container
                    $('#attributes').find('div').remove();

                    // Create and Append Attributes Input
                    response.attrubtes.forEach(attribute => {
                            let formgroupselect = $('<div/>', {
                                class: 'form-group col-md-3',
                            })
                            formgroupselect.append(
                                $('<label/>', {
                                    for: attribute.name,
                                    text: attribute.name
                                })
                            )
                            formgroupselect.append(
                                $('<input/>', {
                                    class: 'form-control',
                                    id: attribute.name,
                                    name: `attribute_ids[${attribute.id}]`,
                                    type: 'text'
                                })
                            );
                            $('#attributes').append(formgroupselect);
                        }
                    )
                    $('#variation_name').html(response.variation.name);

                }
            });
        });
        $("#czContainer").czMore();

    </script>
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ایجاد محصول</h5>
            </div>
            <hr>

            @include('admin.sections.errors')

            <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{old('name')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="brandSelect">برند</label>
                        <select class="form-control" id="brandSelect" name="brand_id">
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" selected>فعال</option>
                            <option value="0">غیرفعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="tagsSelect">تگ ها</label>
                        <select id="tagsSelect" name="tag_ids[]" class="form-control" multiple
                                data-live-search="true">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description"
                                  name="description">{{old('description')}}</textarea>
                    </div>

                    {{-- Product Image Section --}}
                    <div class="col-md-12">
                        <hr>
                        <p>تصاویر محصول : </p>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="primary_image"> انتخاب تصویر اصلی </label>
                        <div class="custom-file">
                            <input type="file" name="primary_image" class="custom-file-input" id="primary_image">
                            <label class="custom-file-label" for="primary_image"> انتخاب فایل </label>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="images"> انتخاب تصاویر </label>
                        <div class="custom-file">
                            <input class="custom-file-input" id="images" type="file" name="images[]" multiple>
                            <label class="custom-file-label" for="images"> انتخاب فایل ها </label>
                        </div>
                    </div>
                    {{-- Category&Attributes Section --}}
                    <div class="col-md-12">
                        <hr>
                        <p>دسته بندی و ویژگی ها : </p>
                    </div>

                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="form-group col-md-3">
                                <label for="categorySelect">دسته بندی</label>
                                <select id="categorySelect" name="category_id" class="form-control"
                                        data-live-search="true">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }} -
                                            {{ $category->parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="attributesContainer" class="col-md-12">
                        <div id="attributes" class="row"></div>
                        <div class="col-md-12">
                            <hr>
                            <p>افزودن قیمت و موجودی برای متغییر <span class="font-weight-bold text-info"
                                                                      id="variation_name"></span>:
                            </p>
                        </div>
                        <div id="czContainer">
                            <div id="first">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label >نام</label>
                                        <input class="form-control"  name="attribute_variation[value][]" type="text">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label >قیمت</label>
                                        <input class="form-control"  name="attribute_variation[price][]" type="text">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label >تعداد</label>
                                        <input class="form-control"  name="attribute_variation[quantity][]" type="text">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label > شناسه انبار</label>
                                        <input class="form-control"  name="attribute_variation[sku][]" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- Delivery Section --}}
                <div class="col-md-12">
                    <hr>
                    <p>هزینه ارسال : </p>
                </div>

                <div class="form-group col-md-3">
                    <label for="delivery_amount">هزینه ارسال</label>
                    <input class="form-control" id="delivery_amount" name="delivery_amount" type="text" value="{{ old('delivery_amount') }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="delivery_amount_per_product">هزینه ارسال به ازای محصول اضافی</label>
                    <input class="form-control" id="delivery_amount_per_product" name="delivery_amount_per_product" type="text" value="{{ old('delivery_amount_per_product') }}">
                </div>

                </div>
                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
