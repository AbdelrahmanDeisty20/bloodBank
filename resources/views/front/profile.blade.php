@extends('front.master')
@section('content')
    <!--form-->
    <div class="form">
        <div class="container">
            <div class="path">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> الصفحة الشخصية</li>
                    </ol>
                </nav>
            </div>
            @if (session()->has('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif
            <div class="signin-form">
                <form method="POST" action="{{ route('profile.profileSave') }}">
                    @csrf
                    <div class="logo">
                        <img src="{{ asset('front/imgs/logo.png') }}">
                    </div>
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            placeholder="الجوال" value="{{auth('client-web')->user()->phone}}" >
                    </div>

                    @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" id="email"
                            aria-describedby="emailHelp" placeholder="الايميل" value="{{auth('client-web')->user()->email}}" required >
                    </div>

                    {{-- @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}

                    <div class="form-group">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" placeholder="كلمة المرور" value="" required>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" placeholder="تأكيد كلمة المرور" value="" required >

                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    <div class="row options">
                    </div>
                    <div class="row buttons">
                        <div class="col-md-6 right">
                            <input type="submit" class="btn btn-danger" value="تغيير الصفحة الشخصية">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
