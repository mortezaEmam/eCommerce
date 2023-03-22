@extends('admin.layouts.admin')

@section('title')
    edit product category
@endsection

@section('scripts')
    <script>
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
                <h5 class="font-weight-bold">ویرایش دسته بندی محصول:{{$product->name}}</h5>
            </div>
            <hr>

            @include('admin.sections.errors')

            <form action="{{ route('admin.products.updateProductCategory',['product' => $product->id]) }}"
                  method="post">
                @csrf
                @method('PUT')

                <div class="form-row">
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
                                        <option
                                            value="{{ $category->id }}" {{($category->id == $product->category->id) ? "selected" :""}}>{{ $category->name }}
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
                                        <label>نام</label>
                                        <input class="form-control" name="attribute_variation[value][]" type="text">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>قیمت</label>
                                        <input class="form-control" name="attribute_variation[price][]" type="text">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>تعداد</label>
                                        <input class="form-control" name="attribute_variation[quantity][]" type="text">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label> شناسه انبار</label>
                                        <input class="form-control" name="attribute_variation[sku][]" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
