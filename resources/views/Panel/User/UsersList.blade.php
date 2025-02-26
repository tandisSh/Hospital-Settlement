@extends('Panel.layouts.Master')

@section('content')
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <div class="row justify-content-center mt-5">
                <div class="col-lg-10">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <!-- عنوان لیست کاربران و دکمه ثبت کاربر جدید -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">لیست کاربران</h4>
                                <a href="#" class="btn btn-warning btn-sm px-3">ثبت کاربر جدید +</a>
                            </div>

                            <!-- جدول کاربران -->
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center">ردیف</th>
                                            <th class="text-center">شناسه</th>
                                            <th class="text-center">نام کاربر</th>
                                            <th class="text-center d-none d-md-table-cell">تلفن</th>
                                            <th class="text-center d-none d-md-table-cell">ایمیل</th>
                                            <th class="text-center">نوع کاربر</th>
                                            <th class="text-center">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($users as $index => $user) --}}
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td class="text-center">123</td>
                                                <td class="text-center">نام کاربر نمونه</td>
                                                <td class="text-center d-none d-md-table-cell">09123456789</td>
                                                <td class="text-center d-none d-md-table-cell">example@gmail.com</td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary">کاربر عادی</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="#" class="btn btn-info btn-sm px-2" title="مشاهده">
                                                            <i class="fa fa-eye text-dark"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-warning btn-sm px-2" title="ویرایش">
                                                            <i class="fa fa-pen text-dark"></i>
                                                        </a>
                                                        <a href="" class="btn btn-danger btn-sm px-2" title="حذف">
                                                            <i class="fa fa-trash text-dark"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
