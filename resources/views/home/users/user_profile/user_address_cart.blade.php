<!-- Single Tab Content Start -->
<div class="col-lg-9 col-md-8">
    <div class="tab-content">
        <div class="myaccount-content">

            <h3> آدرس ها </h3>

            <div>
                <address>
                    <p>
                        <strong> علی شیخ </strong>
                        <span class="mr-2"> عنوان آدرس : <span> منزل </span> </span>
                    </p>
                    <p>
                        خ شهید فلان ، کوچه ۸ فلان ،فرعی فلان ، پلاک فلان
                        <br>
                        <span> استان : تهران </span>
                        <span> شهر : تهران </span>
                    </p>
                    <p>
                        کدپستی :
                        89561257
                    </p>
                    <p>
                        شماره موبایل :
                        89561257
                    </p>

                </address>
                <a href="#" class="check-btn sqr-btn collapse-address-update">
                    <i class="sli sli-pencil"></i>
                    ویرایش آدرس
                </a>

                <div class="collapse-address-update-content">

                    <form action="#">

                        <div class="row">

                            <div class="tax-select col-lg-6 col-md-6">
                                <label>
                                    عنوان
                                </label>
                                <input type="text" required="" name="title">
                            </div>
                            <div class="tax-select col-lg-6 col-md-6">
                                <label>
                                    شماره تماس
                                </label>
                                <input type="text">
                            </div>
                            <div class="tax-select col-lg-6 col-md-6">
                                <label>
                                    استان
                                </label>
                                <select class="email s-email s-wid">
                                    <option>Bangladesh</option>
                                    <option>Albania</option>
                                    <option>Åland Islands</option>
                                    <option>Afghanistan</option>
                                    <option>Belgium</option>
                                </select>
                            </div>
                            <div class="tax-select col-lg-6 col-md-6">
                                <label>
                                    شهر
                                </label>
                                <select class="email s-email s-wid">
                                    <option>Bangladesh</option>
                                    <option>Albania</option>
                                    <option>Åland Islands</option>
                                    <option>Afghanistan</option>
                                    <option>Belgium</option>
                                </select>
                            </div>
                            <div class="tax-select col-lg-6 col-md-6">
                                <label>
                                    آدرس
                                </label>
                                <input type="text">
                            </div>
                            <div class="tax-select col-lg-6 col-md-6">
                                <label>
                                    کد پستی
                                </label>
                                <input type="text">
                            </div>

                            <div class=" col-lg-12 col-md-12">
                                <button class="cart-btn-2" type="submit"> ویرایش
                                    آدرس
                                </button>
                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <hr>
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
