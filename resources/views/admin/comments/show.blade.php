@extends('admin.layouts.admin')

@section('title')
    show-comment
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">نظر شماره :{{$comment->id}}</h5>
            </div>
            <hr>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>نام کاربر</label>
                    <input class="form-control" value="{{$comment->user->name ?:$comment->user->cellphone}}" type="text" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>نام محصول</label>
                    <input class="form-control" value="{{$comment->product->name}}" type="text" disabled>
                </div>
                <div class="form-group col-md-12">
                    <label>محتوا</label>
                    <textarea class="form-control" disabled>{{$comment->text}}</textarea>
                </div>
                <div class="form-group col-md-3">
                    <label>وضعیت</label>
                    <input class="form-control {{$comment->getRaworiginal('approved')? 'text-success' : 'text-danger'}}" value="{{$comment->approved}}" type="text" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label>تاریخ ایجاد</label>
                    <input class="form-control" value="{{verta($comment->created_at)}}" type="text" disabled>
                </div>
                <br>
            </div>
            <div>
                <a href="{{ route('admin.comments.index') }}" class="btn btn-outline-info mt-5 ">بازگشت</a>
            </div>
        </div>
    </div>

@endsection
