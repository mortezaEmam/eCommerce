@extends('admin.layouts.admin')

@section('title')
    show-brands
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">برند : {{$brand->name}}</h5>
            </div>
            <hr>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>نام</label>
                    <input class="form-control" value="{{$brand->name}}" type="text" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>وضعیت</label>
                    <input class="form-control" value="{{$brand->is_active}}" type="text" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>تاریخ ایجاد</label>
                    <input class="form-control" value="{{verta($brand->created_at)}}" type="text" disabled>
                </div>
                <br>
            </div>
            <div>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-info mt-5 ">بازگشت</a>
            </div>
        </div>
    </div>

@endsection
