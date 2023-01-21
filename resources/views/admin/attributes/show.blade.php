@extends('admin.layouts.admin')

@section('title')
    show-attribute
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ویژگی : {{$attribute->name}}</h5>
            </div>
            <hr>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>نام</label>
                    <input class="form-control" value="{{$attribute->name}}" type="text" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label>تاریخ ایجاد</label>
                    <input class="form-control" value="{{verta($attribute->created_at)}}" type="text" disabled>
                </div>
                <br>
            </div>
            <div>
                <a href="{{ route('admin.attributes.index') }}" class="btn btn-outline-info mt-5 ">بازگشت</a>
            </div>
        </div>
    </div>

@endsection
