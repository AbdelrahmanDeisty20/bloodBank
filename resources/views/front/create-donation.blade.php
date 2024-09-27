@extends('front.master')
@section('content')
    <!--form-->
    <div class="form">
        <div class="container">
            <div class="path">
                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">انشاء متبرع جديد</li>
                    </ol>
                </nav>
            </div>
            @if (session()->has('success', 'error'))
                <div class="alert alert-success">
                    {{ session('success', 'error') }}
                </div>
            @endif
            <div class="account-form">
                <form method="POST" action="{{ route('donation-create.donation_request_create_save') }}">
                    @csrf
                    <input type="text" class="form-control @error('patient_age') is-invalid @enderror " id="exampleInputEmail1" aria-describedby="emailHelp"
                        placeholder="اسم المريض"  name="patient_name">

                        @error('patient_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="text" class="form-control @error('patient_age') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp"
                        placeholder="اسم المستشفى"  name="hospital_name">

                        @error('hospital_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input placeholder="عمر المريض" class="form-control @error('patient_age') is-invalid @enderror "
                        type="text" id="patient_age"  name="patient_age">

                    @error('patient_age')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <select class="form-control @error('blood_type_id') is-invalid @enderror" name="blood_type_id" id="blood_type_id">
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

                    @inject('governorates', 'App\Models\Governorate')
                    <select name="governorate_id" class="form-control" id="governorates">
                        <option value="">اختر محافظة</option>
                        @foreach ($governorates->pluck('name', 'id')->toArray() as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <select class="form-control  @error('city_id') is-invalid @enderror" id="cities" name="city_id">
                        <option selected disabled hidden value="">اختر مدينة</option>
                    </select>

                    @error('city_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="text" class="form-control @error('phone') is-invalid @enderror " id="exampleInputEmail1"
                        name="patient_phone"  aria-describedby="emailHelp" placeholder="رقم الهاتف">

                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror


                    <input placeholder="عدد الاكياس المطلوبة" class="form-control @error('bags_num') is-invalid @enderror"
                        type="text"  id="bags_num" name="bags_num">

                    @error('bags_num')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="text" class="form-control @error('hospital_address') is-invalid @enderror" name="hospital_address" id="hospital_address" placeholder="عنوان المستشفى">

                        @error('hospital_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="number" step="0.0001" class="form-control @error('longtude') is-invalid @enderror" id="longitude" name="longtude"
                        placeholder="خط الطول">

                        @error('longtude')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="text" class="form-control @error('details') is-invalid @enderror" id="" name="details"  placeholder="الملاحظات ">

                        @error('details')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="number" step="0.0001" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" placeholder="خط العرض">

                        @error('latitude')
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
