@extends('front.master')
@section('content')
    <!--form-->
    <div class="form">
        <div class="container">
            <div class="path">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">نسيت كلمة المرور</li>
                    </ol>
                </nav>
            </div>

            <div class="signin-form">
                <form method="POST" action="{{ route('resset-password.Password') }}">
                    @csrf
                    <div class="logo">
                        <img src="{{ asset('front/imgs/logo.png') }}">
                    </div>
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-error">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="الجوال">

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror


                    <div class="row buttons">
                        <div class="col-md-6 right">
                            <input type="submit" class="btn btn-danger" value="ارسال">
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
