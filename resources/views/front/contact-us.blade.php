@extends('front.master')
@section('content')
    <!--contact-us-->
    <div class="contact-now">
        <div class="container">
            <div class="path">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">تواصل معنا</li>
                    </ol>
                </nav>
            </div>
            <div class="row methods">
                <div class="col-md-6">
                    <div class="call">
                        <div class="title">
                            <h4>اتصل بنا</h4>
                        </div>
                        <div class="content">
                            <div class="logo">
                                <img src="{{ asset('front/imgs/logo.png') }}">
                            </div>
                            <div class="details">
                                <ul>
                                    <li><span>الجوال:</span> {{ $settings->phone }}</li>
                                    {{-- <li><span>فاكس:</span> 234234234</li> --}}
                                    <li><span>البريد الإلكترونى:</span> {{ $settings->email }}</li>
                                </ul>
                            </div>
                            <div class="social">
                                <h4>تواصل معنا</h4>
                                <div class="icons" dir="ltr">
                                    <div class="out-icon">
                                        <a href="{{ $settings->facebook_link }}" target="blank"><i
                                                class="fab fa-facebook-f"></i></a>
                                    </div>
                                    <div class="out-icon">
                                        <a href="{{ $settings->twitter_link }}" target="blank"><i
                                                class="fab fa-twitter"></i></a>
                                    </div>
                                    <div class="out-icon">
                                        <a href="{{ $settings->youtube_link }}" target="blank"><i
                                                class="fab fa-youtube"></i></a>
                                    </div>
                                    <div class="out-icon">
                                        <a href="{{ $settings->instagram_link }}" target="blank"><i
                                                class="fab fa-instagram"></i></a>
                                    </div>
                                    <div class="out-icon">
                                        <a href="{{ $settings->phone }}" target="blank"><i class="fab fa-whatsapp"></i></a>
                                    </div>
                                    {{-- <div class="out-icon">
                                        <a href="#"><img src="imgs/006-google-plus.svg"></a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-form">
                        <div class="title">
                            <h4>تواصل معنا</h4>
                        </div>
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="fields">
                            <form method="POST" action="{{ route('contact-us.contact') }}">
                                @csrf
                                <input type="text" required class="form-control" id="exampleFormControlInput1"
                                    placeholder="الإسم" name="name">
                                <input type="email" required class="form-control" id="exampleFormControlInput1"
                                    placeholder="البريد الإلكترونى" name="email">
                                <input type="text" required class="form-control" id="exampleFormControlInput1"
                                    placeholder="الجوال" name="phone">
                                <input type="text" required class="form-control" id="exampleFormControlInput1"
                                    placeholder="عنوان الرسالة" name="subject">
                                <textarea required placeholder="نص الرسالة" class="form-control" id="exampleFormControlTextarea1" rows="3"
                                    name="messge"></textarea>
                                <button type="submit" class="btn btn-info">ارسال</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
