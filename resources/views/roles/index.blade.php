@extends('layouts.app')
@section('page_title')
    <h1>رتب المستخدمين</h1>
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">كل الرتب </h3>

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
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if (count($records))
                    <a href="{{ url(route('role.create')) }}" class="btn btn-primary"><i class="fa fa-plus"></i>اضافة
                        رتبة مستخدم جديد</a>

                    <div class="table-responsive">
                        <table class="table table-bordered" style="margin-top: 10px">
                            <thead>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الرتبة</th>
                                <th class="text-center">تعديل</th>
                                <th class="text-center">حذف</th>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $record->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('role.edit', $record->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('role.destroy', $record->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('هل أنت متأكد من حذف هذه الفئة؟')"><i
                                                        class="fa fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <a href="{{ url(route('role.create')) }}" class="btn btn-primary"><i class="fa fa-plus"></i>اضافة
                        رتبة مستخدم جديد</a>
                    <br>
                    <br>
                    <div class="alert alert-danger" role="alert">
                        لاتوجد بيانات
                    </div>
                @endif
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
