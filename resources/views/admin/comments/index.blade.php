@extends('admin.layouts.admin')

@section('title')
    list-comments
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست نظرات ({{ $comments->total() }})</h5>
            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام کاربر</th>
                        <th>نام محصول</th>
                        <th>محتوا</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($comments as $key => $comment)
                        <tr>
                            <th>
                                {{$comments->firstItem() + $key}}
                            </th>
                            <th>
                                {{$comment->user->name ?:$comment->user->cellphone}}
                            </th>
                            <th>
                                <a href="{{route('admin.products.show' , ['product' => $comment->product->id])}}">{{$comment->product->name}}</a>

                            </th>
                            <th>
                                {{$comment->text}}
                            </th>
                            <th class="{{$comment->getRaworiginal('approved')? 'text-success' : 'text-danger'}}">
                                {{$comment->approved}}
                            </th>
                            <th>
                                <a class="btn btn-outline-success"
                                   href="{{route('admin.comments.show',['comment' => $comment->id])}}">نمایش</a>

                                <form action="{{route('admin.comments.destroy',['comment' => $comment->id])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-outline-danger  mb-4" value="حذف"/>
                                </form>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $comments->render() }}
            </div>
        </div>
    </div>
@endsection

