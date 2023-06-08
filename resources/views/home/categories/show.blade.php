@extends('home.layouts.home')

@section('title')
    صفحه اصلی
@endsection

@section('scripts')
    <script src="{{asset('js/home.js')}}"></script>
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

        $('#pagination li a').map(function () {
            let decodeUrl = decodeURIComponent($(this).attr('href'));
            if ($(this).attr('href') !== undefined) {
                $(this).attr('href', decodeUrl);
            }
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
                                        {{$category->parent==null?$category->name:$category->parent->name}}
                                    </li>
                                    @php
                                        $categoryChildern = $category->parent==null?$category->childern:$category->parent->childern;
                                    @endphp
                                    @foreach($categoryChildern as $childern)
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
                    @if(blank($products))
                        <div class="container cart-empty-content">
                            <div class="row justify-content-center">
                                <div class="col-md-6 text-center">
                                    <i class="sli sli-shield"></i>
                                    <h2 class="font-weight-bold my-4">محصول در این دسته بندی وجود ندارد</h2>
                                    <p class="mb-40">انبار ما از این محصول خالی هست</p>
                                    <a href="{{route('home.index')}}"> مشاهده بقیه محصولات </a>
                                </div>
                            </div>
                        </div>
                    @else
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
                            <div id="pagination" class="pro-pagination-style text-center mt-30">
                                {{-- for url is clean use withQueryString--}}
                                {{ $products->withQueryString()->links() }}
                            </div>
                        </div>
                    @endif

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
    @if(!blank($products))
        @foreach($products as $product)
            @include('home.front.modal.product')
        @endforeach
    @endif
    </div>

@endsection
