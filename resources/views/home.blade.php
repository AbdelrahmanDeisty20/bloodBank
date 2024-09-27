@extends('layouts.app')
@inject('client', 'App\Models\Client')
@inject('donation', 'App\Models\donationRequest')
@inject('post', 'App\Models\Post')
@inject('category', 'App\Models\CatgoryType')
@inject('governorate', 'App\Models\Governorate')
@inject('cities', 'App\Models\City')
@inject('user', 'App\Models\User')
@inject('bloodType', 'App\Models\BloodType')
@inject('contact', 'App\Models\Contact')

@section('page_title')
    Dashboard
@endsection

@section('small_title')
    statistics
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">clients</span>
                        <span class="info-box-number">{{ $client->count() }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-line-chart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">donation requests</span>
                        <span class="info-box-number">{{ $donation->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-comment-o" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">posts</span>
                        <span class="info-box-number">{{ $post->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-list" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">categories</span>
                        <span class="info-box-number">{{ $category->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">governorates</span>
                        <span class="info-box-number">{{ $governorate->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-flag" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">cities</span>
                        <span class="info-box-number">{{ $cities->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-users" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">users</span>
                        <span class="info-box-number">{{ $user->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-tint" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">blood types</span>
                        <span class="info-box-number">{{ $bloodType->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-comment-o" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">contacts</span>
                        <span class="info-box-number">{{ $contact->count() }}</span>
                    </div>
                </div>
            </div>
    </section>
    <!-- /.content -->
@endsection
