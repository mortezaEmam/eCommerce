@extends('home.layouts.home')

@section('title')
    صفحه ثبت نام
@endsection

@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="index.html">صفحه ای اصلی</a>
                    </li>
                    <li class="active"> ورود </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="login-register-area pt-100 pb-100" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="" href="#lg2">
                                <h4> عضویت </h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg2" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{route('register')}}" method="post">
                                            @csrf
                                            <input name="name"  class="@error('name')mb-1 @enderror" placeholder="نام کاربری" type="text" value="{{old('name')}}">
                                            @error('name')
                                            <div class="input-error-validation">
                                                <span>{{$message}}</span>
                                            </div>
                                            @enderror
                                            <input name="email" class="@error('email')mb-1 @enderror"  placeholder="ایمیل" type="email"  value="{{old('email')}}">
                                            @error('email')
                                            <div class="input-error-validation">
                                                <span>{{$message}}</span>
                                            </div>
                                            @enderror
                                            <input type="password" class="@error('password')mb-1 @enderror"  name="password" placeholder="رمز عبور"  value="{{old('password')}}">
                                            @error('password')
                                            <div class="input-error-validation">
                                                <span>{{$message}}</span>
                                            </div>
                                            @enderror
                                            <input type="password" class="@error('password_confirmation')mb-1 @enderror"  name="password_confirmation" placeholder="تکرار رمز عبور"  value="{{old('confirm-password')}}">
                                            @error('confirm-password')
                                            <div class="input-error-validation">
                                                <span>{{$message}}</span>
                                            </div>
                                            @enderror
                                            <div class="button-box">
                                                <button type="submit">عضویت</button>
                                                <a href="{{route('auth.provider-to-redirect',['provider' => 'google'])}}" class="btn btn-google btn-block mt-4">
                                                    <i class="sli sli-social-google"></i>
                                                    ایجاد اکانت با گوگل
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
