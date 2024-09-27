@extends('layouts.app')
@inject('model', 'App\models\Governorate')
@section('page_title')
    انشاء مدينة
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">اضف مدينة جديدة </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form action="{{ route('cities.store') }}" method="POST" id="governorate-form">
                    @csrf
                    <div class="form-group">
                        <label for="name">اسم المدينة</label>
                        <input type="text" class="form-control btn-margin @error('name') is-invalid @enderror"
                            id="name" name="name">
                            <br>
                        <select class="form-control btn-margin @error('governorate_id') is-invalid @enderror" id="governorate"
                            name="governorate_id">
                            <option value="">اختار المحافظة</option>
                            @foreach ($governorates as $governorate)
                                <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                            @endforeach
                        </select>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" id="submit-btn">
                    </div>
                </form>
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
