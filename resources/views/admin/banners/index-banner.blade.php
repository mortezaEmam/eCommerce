@extends('admin.layouts.admin')

@section('title')
    list-banners
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست بنر ها ({{ $banners->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.banners.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد بنر
                </a>
            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>تصویر</th>
                        <th>عنوان</th>
                        <th>متن</th>
                        <th>الویت</th>
                        <th>نوع </th>
                        <th>وضعیت</th>
                        <th> متن دکمه</th>
                        <th> لینک دکمه</th>
                        <th> ایکن دکمه</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($banners as $key => $banner)
                        <tr>
                            <th>
                                {{$banners->firstItem() + $key}}
                            </th>
                            <th>
                                <a target="_blank" href="{{Storage::url($banner->image)}}">
                                    {{$banner->image}}
                                </a>
                            </th>
                            <th>
                                {{$banner->title}}
                            </th>
                            <th class="overflow-hidden">
                                {{$banner->text}}
                            </th>
                            <th>
                                {{$banner->priority}}
                            </th>
                            <th>
                                {{$banner->type}}
                            </th>
                            <th class=" {{$banner->getRaworiginal('is_active')? 'text-success' : 'text-danger'}}">
                                {{$banner->is_active}}
                            </th>
                            <th>
                                {{$banner->button_text}}
                            </th>
                            <th>
                                {{$banner->button_link}}
                            </th>
                            <th>
                                {{$banner->button_icon}}
                            </th>

                            <th>
                                <form action="{{route('admin.banners.destroy',['banner' => $banner->id])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-outline-danger  mb-2" value="حذف"/>
                                </form>

                                <a class="btn btn-outline-info"
                                   href="{{route('admin.banners.edit',['banner' => $banner->id])}}">ویرایش</a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $banners->render() }}
            </div>
        </div>
    </div>
@endsection
