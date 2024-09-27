@extends('front.master')
@section('content')
    <!--requests-->
    <div class="requests">
        <div class="head-text">
            <h2>طلبات التبرع</h2>
        </div>
        <div class="content">
            @auth('client-web')
                <a href="{{ route('donation-create.donation_request_create') }}" class="btn btn-primary">اضف متبرعين</a>
            @else
            <p>Please login to add a donation request.</p>
                @endauth
            <form class="row filter" id="search-form" method="get">
                <div class="col-md-5 blood">
                    <div class="form-group">
                        <div class="inside-select">
                            <select class="form-control" id="blood-type" name="blood_type">
                                <option selected disabled>اختر فصيلة الدم</option>
                                @foreach ($bloodTypes as $blood)
                                    <option value="{{ $blood->id }}">{{ $blood->name }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 city">
                    <div class="form-group">
                        <div class="inside-select">
                            <select class="form-control" id="city" name="city">
                                <option selected disabled>اختر المدينة</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-1 search">
                    <button class="search-btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>

                </div>
                @if (session()->has('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif
            </form>
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="patients">
                @foreach ($donations as $donation)
                    <div class="details">
                        <div class="blood-type">
                            <h2 dir="ltr">{{ $donation->bloodType->name }}</h2>
                        </div>
                        <ul>
                            <li><span>اسم الحالة:</span> {{ $donation->patient_name }}</li>
                            <li><span>مستشفى:</span> {{ $donation->hospital_name }} </li>
                            <li><span>المدينة:</span> {{ $donation->city->name }}</li>
                        </ul>
                        <a href="{{ route('donation-requests.donationInformation', $donation->id) }}">التفاصيل</a>
                    </div>
                @endforeach
                <div class="pages">
                    <nav aria-label="Page navigation example" dir="ltr">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link active" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item"><a class="page-link" href="#">6</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    </div>

@stop
