@extends('front.master')
@section('content')
    <!--intro-->
    <div class="intro">
        <div id="slider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#slider" data-slide-to="0" class="active"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item carousel-1 active">
                    <div class="container info">
                        <div class="col-lg-5">
                            <h3>{{ $settings->about_title }}</h3>
                            <p>
                                {{ $settings->about_app }}
                            </p>
                            <a href="{{route('who-are-us.whoAreUs')}}">المزيد</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--about-->
    <div class="about">
        <div class="container">
            <div class="col-lg-6 text-center">
                <p>
                    <span> بنك الدم : </span>
                    {{ $settings->about_appNum2 }}
                </p>
            </div>
        </div>
    </div>

    <!--articles-->
    <div class="articles">
        <div class="container title">
            <div class="head-text">
                <h2>المقالات</h2>
            </div>
        </div>
        <div class="view">
            <div class="container">
                <div class="row">
                    <!-- Set up your HTML -->
                    <div class="owl-carousel articles-carousel">
                        @foreach ($posts as $post)
                            <div class="card">
                                <div class="photo">
                                    <img src="{{ asset($post->image) }}" class="card-img-top" alt="...">
                                    <a href="{{ route('postst.postMore', $post->id) }}" class="click">المزيد</a>
                                </div>
                                    <a href="#"
                                        class="favourite {{ $post->is_favourite ? 'second-heart': 'first-heart'   }}"
                                        onclick="toggleFavourite(this, event)" id="{{ $post->id }}">
                                        <i class="far fa-heart"></i>
                                    </a>

                                <div class="card-body">
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                    <p class="card-text">
                                        {{ $post->content }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--requests-->
    <div class="requests">
        <div class="container">
            <div class="head-text">
                <h2>طلبات التبرع</h2>
            </div>
        </div>
        <div class="content">
            <div class="container">
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
                </form>

                <!-- display filtered results here -->
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
                            <a href="i{{route('donation-requests.donationInformation',$donation->id)}}">التفاصيل</a>
                        </div>
                    @endforeach
                </div>
                <div class="more">
                    <a href="{{ route('donation-requests.donationRequests') }}">المزيد</a>
                </div>
            </div>
        </div>
    </div>

    <!--contact-->
    <div class="contact">
        <div class="container">
            <div class="col-md-7">
                <div class="title">
                    <h3>اتصل بنا</h3>
                </div>
                <p class="text">يمكنك الإتصال بنا للإستفسار عن معلومة وسيتم الرد عليكم</p>
                <div class="row whatsapp">
                    <a href="https://wa.me/{{ $settings->phone }}" target="blank">
                        <img src="{{ asset('front/imgs/whats.png') }}">
                        <p dir="ltr">{{ $settings->phone }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!--app-->
    <div class="app">
        <div class="container">
            <div class="row">
                <div class="info col-md-6">
                    <h3>{{ $settings->about_footer_title }}</h3>
                    <p>
                        {{ $settings->about_footer2 }}
                    </p>
                    <div class="download">
                        <h4>متوفر على</h4>
                        <div class="row stores">
                            <div class="col-sm-6">
                                <a
                                    href="{{ url('https://play.google.com/store/apps/details?id=com.yourcompany.yourapp') }}">
                                    <img src="{{ asset('front/imgs/google.png') }}">
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{ url('https://itunes.apple.com/us/app/yourapp/id123456789') }}">
                                    <img src="{{ asset('front/imgs/ios.png') }}">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="screens col-md-6">
                    <img src="{{ asset('front/imgs/App.png') }}">
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            // $('.search-btn').click(function(event){
            //     event.preventDefault();
            // })

            function toggleFavourite(heart, event) {
                console.log('Toggle favourite called!');
                var post_id = heart.id;
                console.log(post_id);
                $.ajax({
                    url: '{{ url('toggle-favourite') }}',
                    type: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        post_id: post_id
                    },
                    success: function(data) {
                        console.log(data);
                        var currentClass = $(heart).attr('class');
                        if (currentClass.includes('first')) {
                            $(heart).removeClass('first-heart').addClass('second-heart');
                            $(heart).find('i').css('color', 'red'); // add this line
                        } else {
                            $(heart).removeClass('second-heart').addClass('first-heart');
                            $(heart).find('i').css('color', ''); // reset the color
                        }
                    }
                });
                event.preventDefault();
            }
        </script>
    @endpush
@stop
