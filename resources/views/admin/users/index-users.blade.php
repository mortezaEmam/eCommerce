@extends('admin.layouts.admin')

@section('title')
    list-users
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست کاربران ({{ $users->total() }})</h5>
            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام و نام خانوادگی</th>
                        <th>ایمیل</th>
                        <th>شماره همراه</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($users as $key => $user)
                        <tr>
                            <th>
                                {{$users->firstItem() + $key}}
                            </th>
                            <th>
                                {{$user->name}}
                            </th>
                            <th>
                                {{$user->email}}
                            </th>
                            <th>
                                {{$user->cellphone}}
                            </th>
                            <th class=" {{$user->getRaworiginal('is_status')? 'text-success' : 'text-danger'}}">
                                {{$user->is_status}}
                            </th>
                            <th>
                                <a class="btn btn-outline-info" href="{{route('admin.users.edit',['user' => $user->id])}}">ویرایش</a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $users->render() }}
            </div>
        </div>
    </div>
@endsection
