@extends('admin.layouts.admin')

@section('title')
    edit coupons
@endsection

@section('scripts')
    <script>
        $('#expireDate').azPersianDateTimePicker({
            targetTextSelector: '#expireInput',
            englishNumber: true,
            enableTimePicker: true,
            textFormat: 'yyyy-MM-dd HH:mm:ss',
        });
    </script>
@endsection
@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold"> ویرایش کوپن :{{$coupon->id}}</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.coupons.update' ,['coupon' => $coupon->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{old('name',$coupon->name)}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="code">کد</label>
                        <input class="form-control" id="code" name="code" type="text" value="{{old('code',$coupon->code)}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="type">نوع</label>
                        <select class="form-control" id="type" name="type">
                            <option class="text-center">--انتخاب کنید--</option>
                            <option value="percentage" {{$coupon->getRawOriginal('type') == 'percentage'?'selected':''}} >درصدی</option>
                            <option value="amount" {{$coupon->getRawOriginal('type') == 'amount'?'selected':''}}>مبلغی</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="amount">مبلغ</label>
                        <input class="form-control" id="amount" name="amount" type="number" value="{{old('amount',$coupon->amount)}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="percentage">درصد</label>
                        <input class="form-control" id="percentage" name="percentage" type="number" value="{{old('percentage',$coupon->percentage)}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="max_percentage_amount">حداکثر مبلغ برای درصدی</label>
                        <input class="form-control" id="max_percentage_amount" name="max_percentage_amount" type="number" value="{{old('max_percentage_amount',$coupon->max_percentage_amount)}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label> تاریخ انقضا  </label>
                        <div class="input-group">
                            <div class="input-group-prepend order-2">
                                <span class="input-group-text" id="expireDate">
                                    <i class="fas fa-clock"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="expireInput" name="expired_at" value="{{verta($coupon->expired_at)}}">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description"> توضیحات </label>
                        <textarea name="description" class="form-control" id="description">{{ old('description',$coupon->description) }}</textarea>
                    </div>
                    <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
@endsection
