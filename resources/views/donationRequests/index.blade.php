@extends('layouts.app')
@section('page_title')
    <h1>التبرع بالدم</h1>
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">كل المتبرعين </h3>

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
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (count($records))
                    {{-- <a href="{{ url(route('donationRequests.create')) }}" class="btn btn-primary"><i class="fa fa-plus"></i>Add
                    New Donation</a> --}}
                    <div class="table-responsive">
                        <table class="table table-bordered" style="margin-top: 10px">
                            <thead>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم العميل</th>
                                <th class="text-center">اسم المريض</th>
                                <th class="text-center">العمر</th>
                                <th class="text-center">التيلفون</th>
                                <th class="text-center">فئة دم المريض </th>
                                <th class="text-center">اسم المستشفى</th>
                                <th class="text-center">عنوان المستشفى</th>
                                {{-- <th class="text-center">Edit</th> --}}
                                <th class="text-center">حذف</th>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $record->clients->name }}</td>
                                        <td class="text-center">{{ $record->patient_name }}</td>
                                        <td class="text-center">{{ $record->patient_age }}</td>
                                        <td class="text-center">{{ $record->patient_phone }}</td>
                                        <td class="text-center">{{ $record->bloodType->name }}</td>
                                        <td class="text-center">{{ $record->hospital_name }}</td>
                                        <td class="text-center">{{ $record->hospital_address }}</td>
                                        {{-- <td class="text-center">
                                            <a href="{{ route('donationRequests.edit', $record->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        </td> --}}
                                        <td class="text-center">
                                            <form action="{{ route('donationRequests.destroy', $record->id) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger"onclick="return confirm('هل أنت متأكد من حذف هذه الفئة؟')"><i
                                                        class="fa fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        لايوجد بيانات
                    </div>
                @endif
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
