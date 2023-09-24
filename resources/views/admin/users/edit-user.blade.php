@extends('admin.layouts.admin')

@section('title')
    edit user
@endsection

@section('content')
<!-- Content Row -->
 <div class="row">
    <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
        <div class="mb-4">
            <h5 class="font-weight-bold">ویرایش کاربر:{{$user->name}}</h5>
        </div>
        <hr>
        @include('admin.sections.errors')
        <form action="{{ route('admin.users.update',['user'=>$user->id]) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="name">نام و نام خانوادگی</label>
                    <input class="form-control" name="name" type="text" value="{{$user->name}}">
                </div>
                <div class="form-group col-md-3">
                    <label for="email">ایمیل</label>
                    <input class="form-control" name="email" type="email" value="{{$user->email}}">
                </div>
                <div class="form-group col-md-3">
                    <label for="cellphone">شماره همراه</label>
                    <input class="form-control" name="cellphone" type="tel" value="{{$user->cellphone}}">
                </div>
                <div class="form-group col-md-3">
                    <label for="is_status">وضعیت</label>
                    <select class="form-control" name="is_status">
                        <option value="1" {{$user->getRaworiginal('is_status') ? 'selected':''}} >فعال</option>
                        <option value="0" {{!$user->getRaworiginal('is_status') ? 'selected':''}}>غیرفعال</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="role">انتخاب نقش</label>
                    <select class="form-control" name="role">
                        <option value=""></option>
                        @foreach($roles as $role)
                            <option
                                value="{{$role->name}}" {{in_array($role->id,$roles_user)? 'selected':''}}>
                                {{$role->display_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="accordion col-md-12" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-right" type="button" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                پرمیژن ها
                            </button>
                        </h2>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                         data-parent="#accordionExample">
                        <div class="card-body ">
                            @foreach($permissions as $permission)
                                <label class="p-2 "
                                       for="permission_{{$permission->id}}">{{$permission->display_name}}</label>
                                <input type="checkbox" name="{{$permission->name}}" value="{{$permission->name}}"
                                       id="permission_{{$permission->id}}" {{in_array($permission->id,$permissions_user) ? "checked" : ""}}>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </form>
    </div>
 </div>
@endsection
