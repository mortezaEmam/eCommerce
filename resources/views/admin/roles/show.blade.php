@extends('admin.layouts.admin')

@section('title')
    show role
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold"> نمایش نقش </h5>
            </div>
            <hr>
            @include('admin.sections.errors')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="display_name">نام نمایشی</label>
                        <input class="form-control" id="display_name" name="display_name" type="text" value="{{$role->display_name}}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{$role->name}}" readonly>
                    </div>
                </div>
                <div class="accordion col-md-12" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-right" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    پرمیژن ها
                                </button>
                            </h2>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body ">
                                @foreach($permissions_role as $permission)
                                    <label class="p-2 " for="permission_{{$permission->id}}">{{$permission->display_name}}</label>
                                    <input type="checkbox" name="{{$permission->name}}" value="{{$permission->name}}" id="permission_{{$permission->id}}" checked disabled>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </div>

    </div>

@endsection
