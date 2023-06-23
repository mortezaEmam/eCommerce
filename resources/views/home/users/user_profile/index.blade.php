@extends('home.layouts.home')

@section('title')
    صفحه ای پروفایل
@endsection

@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ای اصلی</a>
                    </li>
                    <li class="active"> پروفایل </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- my account wrapper start -->
    <div class="my-account-wrapper pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row text-right" style="direction: rtl;">
                            <div class="col-lg-3 col-md-4">
                                @include('home.section.profile.sidebar_profile')
                            </div>
                            @switch(true)
                                @case(request()->is('profile/comments'))
                                    @include('home.users.user_profile.comments_list')
                                    @break
                                @case(request()->is('profile/wishlists'))
                                    @include('home.users.user_profile.wishlists')
                                    @break
                                @case(request()->is('profile/address-users'))
                                    @include('home.users.user_profile.user_address_cart')
                                    @break
                                @default
                                    @include('home.users.user_profile.profile-cart')
                                @break
                            @endswitch
                        </div>
                    </div>
                    <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
    <!-- my account wrapper end -->
@endsection
