@extends('front.master')
@section('content')
    <!--form-->
    <div class="form">
        <div class="container">
            <div class="path">
                <nav aria-label="breadcrumb">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">انشاء حساب جديد</li>
                    </ol>
                </nav>
            </div>
            @if (session()->has('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif
            <div class="account-form">
                <form method="POST" action="{{ route('register-client.registerSave') }}">
                    @csrf
                    <input type="text" class="form-control  @error('name') is-invalid @enderror" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="الإسم" name="name">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="البريد الإلكترونى" name="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input placeholder="تاريخ الميلاد" class="form-control @error('email') is-invalid @enderror "
                        type="date" onfocus="(this.type='date')" id="date" name="birth_date">

                    @error('birth_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <select class="form-control @error('city_id') is-invalid @enderror" name="blood_type_id" id="blood_type_id" >
                        <option value="">اختر فصيلة الدم</option>
                        @foreach ($bloodTypes as $blood_type)
                            <option value="{{ $blood_type->id }}">{{ $blood_type->name }}</option>
                        @endforeach
                    </select>

                    @error('blood_type_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <select class="form-control" id="governorates" name="governorate" required>
                        <option value="">اختر المحافظة</option>
                        @foreach ($governorates->pluck('name', 'id')->toArray() as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>

                    <select class="form-control @error('city_id') is-invalid @enderror" id="cities" name="city_id">
                        <option selected disabled hidden value="">اختر مدينة</option>
                    </select>

                    @error('city_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="exampleInputEmail1"
                        name="phone"  aria-describedby="emailHelp" placeholder="رقم الهاتف">

                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    {{-- <input placeholder="آخر تاريخ تبرع" class="form-control"
                        type="date" required onfocus="(this.type='date')" id="date" name="donation_last_date"> --}}

                    <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password"
                        id="exampleInputPassword1"  placeholder="كلمة المرور">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="password" class="form-control  @error('password_confirmation') is-invalid @enderror"
                        name="password_confirmation" id="exampleInputPassword1" placeholder="تأكيد كلمة المرور">

                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <div class="create-btn ">
                        <input type="submit" class="btn btn-danger" value="إنشاء"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            $('#governorates').change(function(e) {
                e.preventDefault();
                var governorate_id = $('#governorates').val();
                if (governorate_id) {
                    $.ajax({
                        url: '{{ url('api/v1/cities?governorate_id=') }}' + governorate_id,
                        type: 'get',
                        success: function(data) {
                            if (data.status == 1) {
                                $('#cities').empty();
                                $('#cities').append('<option value="">اختر مدينة</option>');
                                $.each(data.data, function(key, city) {
                                    $('#cities').append('<option value="' + city.id + '">' + city
                                        .name + '</option>');
                                });
                            }
                        }
                    });
                } else {
                    $('#cities').empty();
                    $('#cities').append('<option value="">اختر مدينة</option>');
                }
            })
        </script>
    @endpush
@stop
