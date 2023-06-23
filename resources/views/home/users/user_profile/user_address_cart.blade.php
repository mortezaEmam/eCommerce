<!-- Single Tab Content Start -->
<div class="col-lg-9 col-md-8">
    <div class="tab-content">
        <div class="myaccount-content">

            <h3> آدرس ها </h3>
                @foreach($user_addresses as $user_address)
                 <div>
                    <address>
                        <p>
                            <strong> {{auth()->user()->name?:'کاربر گرامی'}} </strong>
                            <br>
                            <span class="mr-2"> عنوان آدرس : <span> {{$user_address->title}} </span> </span>
                        </p>
                        <p>
                            {{$user_address->address}}
                            <br>
                            <span> استان : {{getProvinceName($user_address->province_id)}} </span>
                            <br>
                            <span> شهر : {{getCityName($user_address->city_id)}} </span>
                        </p>
                        <p>
                            کدپستی :
                            {{$user_address->postal_code}}
                        </p>
                        <p>
                            شماره موبایل :
                            {{$user_address->phone}}
                        </p>

                    </address>
                    <a data-toggle="collapse" href="#collapse-address-{{ $user_address->id }}">
                        <i class="sli sli-pencil"></i>
                        ویرایش آدرس
                    </a>
                     <div id="collapse-address-{{ $user_address->id }}" class="collapse"
                          style="{{ count($errors->addressUpdate) > 0 && $errors->addressUpdate->first('address_id') == $user_address->id ? 'display:block' : '' }}">
                        <form action="{{route('home.address-users.users-profile-update', ['userAddress' => $user_address->id])}}" method="post">
                            @csrf
                            <div class="row">

                                <div class="tax-select col-lg-6 col-md-6">
                                    <label>
                                        عنوان
                                    </label>
                                    <input type="text" name="title" value="{{$user_address->title}}">
                                    @error('title', 'addressUpdate')
                                    <p class="input-error-validation">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                    @enderror
                                </div>
                                <div class="tax-select col-lg-6 col-md-6">
                                    <label>
                                        شماره تماس
                                    </label>
                                    <input type="text" name="phone"  value="{{$user_address->phone}}">
                                    @error('phone', 'addressUpdate')
                                    <p class="input-error-validation">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                    @enderror
                                </div>
                                <div class="tax-select col-lg-6 col-md-6">
                                    <label for="province_id">
                                        استان
                                    </label>
                                    <select id="province-id" class="email s-email s-wid" name="province_id">
                                        <option value="" disabled selected>استان را انتخاب کنید</option>
                                        @foreach($provinces as $province)
                                            <option value="{{$province->id}}" @if($user_address->province_id == $province->id) selected @endif>{{$province->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('province_id', 'addressUpdate')
                                    <p class="input-error-validation">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                    @enderror
                                </div>
                                <div class="tax-select col-lg-6 col-md-6">
                                    <label for="city_id">
                                        شهر
                                    </label>
                                    <select class="email s-email s-wid" name="city_id" id="city-id" >
                                        <option value="{{ $user_address->city_id }}" selected>
                                            {{ getCityName($user_address->city_id) }}
                                        </option>
                                    </select>
                                    @error('city_id', 'addressUpdate')
                                    <p class="input-error-validation">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                    @enderror
                                </div>
                                <div class="tax-select col-lg-6 col-md-6">
                                    <label>
                                        آدرس
                                    </label>
                                    <input type="text" name="address" value="{{$user_address->address}}" >
                                    @error('address', 'addressUpdate')
                                    <p class="input-error-validation">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                    @enderror
                                </div>
                                <div class="tax-select col-lg-6 col-md-6">
                                    <label>
                                        کد پستی
                                    </label>
                                    <input type="text" name="postal_code" value="{{$user_address->postal_code}}">
                                    @error('postal_code', 'addressUpdate')
                                    <p class="input-error-validation">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                    @enderror
                                </div>
                                <div class=" col-lg-12 col-md-12">
                                    <button class="cart-btn-2" type="submit"> ثبت آدرس
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>

            </div>
            <hr>
            @endforeach

            <button class="collapse-address-create mt-3" type="submit"> ایجاد آدرس
                جدید
            </button>
            <div class="collapse-address-create-content" style="{{ count($errors->addressStore) > 0 ? 'display:block' : '' }}">

                <form action="{{route('home.users_profile.address_users_store')}}" method="post">
                    @csrf

                    <div class="row">

                        <div class="tax-select col-lg-6 col-md-6">
                            <label>
                                عنوان
                            </label>
                            <input type="text" name="title" value="{{old('title')}}">
                            @error('title', 'addressStore')
                            <p class="input-error-validation">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="tax-select col-lg-6 col-md-6">
                            <label>
                                شماره تماس
                            </label>
                            <input type="text" name="phone"  value="{{old('phone')}}">
                            @error('phone', 'addressStore')
                            <p class="input-error-validation">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="tax-select col-lg-6 col-md-6">
                            <label for="province_id">
                                استان
                            </label>
                            <select id="province-id" class="email s-email s-wid" name="province_id">
                                <option value="" disabled selected>استان را انتخاب کنید</option>
                                @foreach($provinces as $province)
                                    <option value="{{$province->id}}" @if(old('province_id') == $province->id) selected @endif>{{$province->name}}</option>
                                @endforeach
                            </select>
                            @error('province_id', 'addressStore')
                            <p class="input-error-validation">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="tax-select col-lg-6 col-md-6">
                            <label for="city_id">
                                شهر
                            </label>
                            <select class="email s-email s-wid" name="city_id" id="city-id" >
                            </select>
                            @error('city_id', 'addressStore')
                            <p class="input-error-validation">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="tax-select col-lg-6 col-md-6">
                            <label>
                                آدرس
                            </label>
                            <input type="text" name="address" value="{{old('address')}}" >
                            @error('address', 'addressStore')
                            <p class="input-error-validation">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="tax-select col-lg-6 col-md-6">
                            <label>
                                کد پستی
                            </label>
                            <input type="text" name="postal_code" value="{{old('postal_code')}}">
                            @error('postal_code', 'addressStore')
                            <p class="input-error-validation">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class=" col-lg-12 col-md-12">
                            <button class="cart-btn-2" type="submit"> ثبت آدرس
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<!-- Single Tab Content End -->
@section('scripts')
    <script>
            $(document).ready(function () {
            $('#province-id').on('change', function () {
                var idProvince = this.value;
                $("#city-id").html('');
                $.ajax({
                    url: "{{url('provinces/get-cities')}}",
                    type: "POST",
                    data: {
                        province_id: idProvince,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#city-id').html('<option value=""> شهر را انتخاب کنید </option>');
                        $.each(result.cities, function (key, value) {
                            $("#city-id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
@endsection
