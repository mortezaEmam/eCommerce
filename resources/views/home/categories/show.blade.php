@extends('home.layouts.home')

@section('title')
    صفحه اصلی
@endsection

@section('scripts')
    <script src="{{asset('product/fronts/product-model.js')}}"></script>
    <script>
        function filter() {
            let attributes = @json($attributes);
            attributes.map(attribute => {
                let AttributeValue = $(`.attribute-${attribute.id}:checked`).map(function () {
                    return this.value;
                }).get().join('-');
                if (AttributeValue == "") {
                    $(`#attribute_filter_${attribute.id}`).prop('disabled', true);
                } else {
                    $(`#attribute_filter_${attribute.id}`).val(AttributeValue);
                }
            })
            let variation = $('.variation:checked').map(function () {
                return this.value;
            }).get().join('-');
            if (variation == "") {
                $('#variation_filter').prop('disabled', true);
            } else {
                $('#variation_filter').val(variation);
            }

            let search = $('#search-input').val();
            console.log(search);
            if (search == "") {
                $('#search_filter').prop('disabled', true);
            } else {
                $('#search_filter').val(search)
            }

            let sortBy = $('#sort-by').val();
            if (sortBy == "default") {
                $('#filter-sort-by').prop('disabled', true);
            } else {
                $('#filter-sort-by').val(sortBy);
            }
            $('#filter-form').submit();
        }

        $('#filter-form').on('submit', function (e) {
            e.preventDefault();
            let urlCurrent = `{{url()->current()}}`;
            let url = urlCurrent + '?' + decodeURIComponent($(this).serialize());
            $(location).attr('href', url);
        });
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
    <div class="shop-area pt-95 pb-100">
        <div class="container">
            <div class="row flex-row-reverse text-right">

                <!-- sidebar -->
                <div class="col-lg-3 order-2 order-sm-2 order-md-1">
                    <div class="sidebar-style mr-30">
                        <div class="sidebar-widget">
                            <h4 class="pro-sidebar-title">جستجو </h4>
                            <div class="pro-sidebar-search mb-50 mt-25">
                                <div class="pro-sidebar-search-form">
                                    <input id="search-input" type="text" placeholder="... جستجو "
                                           value="{{ request()->has('search') ? request()->search : '' }}">
                                    <button type="button" onclick="filter()">
                                        <i class="sli sli-magnifier"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-widget">
                            <h4 class="pro-sidebar-title"> دسته بندی </h4>
                            <div class="sidebar-widget-list mt-30">
                                <ul>
                                    <li>
                                        {{$category->parent->name}}
                                    </li>
                                    @foreach($category->parent->childern as $childern)
                                        <li>
                                            <a href="{{route('home.categories.show',['category' => $childern->slug])}}"
                                               style="{{$childern->name == $category->name ? 'color: #ff3535':''}}">
                                                {{$childern->name}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr>

                        <div class="sidebar-widget mt-30">
                            @foreach($attributes as $attribute)
                                <h4 class="pro-sidebar-title">{{$attribute->name}} </h4>
                                <div class="sidebar-widget-list mt-20">
                                    <ul>
                                        @foreach($attribute->values as $value)
                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" class="attribute-{{$attribute->id}}"
                                                           value="{{$value->value}}" onchange="filter()"
                                                        {{(request()->has('attribute.'.$attribute->id) && in_array($value->value,explode('-',request()->attribute[$attribute->id])))?'checked':''}}
                                                    > <a
                                                        href="#">{{$value->value}} </a>

                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                                <hr>
                            @endforeach

                        </div>

                        <div class="sidebar-widget mt-30">
                            <h4 class="pro-sidebar-title">{{$variation->name}} </h4>
                            <div class="sidebar-widget-list mt-20">
                                <ul>
                                    @foreach($variation->VariationValues as $value)
                                        <li>
                                            <div class="sidebar-widget-list-left">
                                                <input type="checkbox" class="variation" value="{{$value->value}}"
                                                       onchange="filter()"
                                                    {{(request()->has('variation') && in_array($value->value ,explode('-',request('variation')))) ? 'checked' : ''}}
                                                > <a
                                                    href="#">{{$value->value}} </a>
                                                <span class="checkmark"></span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- content -->
                <div class="col-lg-9 order-1 order-sm-1 order-md-2">
                    <!-- shop-top-bar -->
                    <div class="shop-top-bar" style="direction: rtl;">

                        <div class="select-shoing-wrap">
                            <div class="shop-select">
                                <select id="sort-by" onchange="filter()">
                                    <option value="default"> مرتب سازی</option>
                                    <option value="max"
                                        {{ request()->has('sortBy') && request()->sortBy == 'max' ? 'selected' : '' }}>
                                        بیشترین قیمت
                                    </option>
                                    <option value="min"
                                        {{ request()->has('sortBy') && request()->sortBy == 'min' ? 'selected' : '' }}>
                                        کم
                                        ترین قیمت
                                    </option>
                                    <option value="latest"
                                        {{ request()->has('sortBy') && request()->sortBy == 'latest' ? 'selected' : '' }}>
                                        جدیدترین
                                    </option>
                                    <option value="oldest"
                                        {{ request()->has('sortBy') && request()->sortBy == 'oldest' ? 'selected' : '' }}>
                                        قدیمی ترین
                                    </option>
                                </select>
                            </div>

                        </div>

                    </div>

                    <div class="shop-bottom-area mt-35">
                        <div class="tab-content jump">

                            <div class="row ht-products" style="direction: rtl;">
                                @foreach($products as $product)
                                    <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
                                        @include('home.front.sections.product')
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="pro-pagination-style text-center mt-30">
                            <ul class="d-flex justify-content-center">
                                <li><a class="prev" href="#"><i class="sli sli-arrow-left"></i></a></li>
                                <li><a class="active" href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a class="next" href="#"><i class="sli sli-arrow-right"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="filter-form">
        @foreach($attributes as $attribute)
            <input type="hidden" id="attribute_filter_{{$attribute->id}}" name="attribute[{{$attribute->id}}]" value="">
        @endforeach
        <input type="hidden" id="variation_filter" name="variation" value="">
        <input type="hidden" id="search_filter" name="search">
        <input id="filter-sort-by" type="hidden" name="sortBy">
    </form>
    @foreach($products as $product)
        @include('home.front.modal.product')
    @endforeach
    </div>

@endsection
