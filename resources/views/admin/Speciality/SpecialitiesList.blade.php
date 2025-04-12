@extends('admin.layouts.Master')

@section('content')
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <div class="row justify-content-center mt-5">
                <div class="col-lg-10">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">لیست تخصص‌ها</h4>
                                <a href="{{ route('Speciality.Create.Form') }}" class="btn btn-primary btn-sm px-3">ثبت تخصص
                                    جدید +</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center">ردیف</th>
                                            <th class="text-center">شناسه</th>
                                            <th class="text-center">عنوان تخصص</th>
                                            <th class="text-center">وضعیت</th>
                                            <th class="text-center">تاریخ ثبت</th>
                                            <th class="text-center">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($specialities as $index => $speciality)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $speciality->id }}</td>
                                                <td class="text-center">{{ $speciality->title }}</td>
                                                <td class="text-center">
                                                    @if ($speciality->status)
                                                        <span class="badge bg-success">فعال</span>
                                                    @else
                                                        <span class="badge bg-danger">غیرفعال</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    {{ $speciality->getCreatedAtShamsi()->format('H:i - Y/m/d') }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ route('Speciality.Edit', $speciality->id) }}"
                                                            class="btn btn-warning btn-sm px-2" title="ویرایش">
                                                            <i class="fa fa-pen text-light"></i>
                                                        </a>
                                                        <form id="delete-form-{{ $speciality->id }}" method="POST"
                                                            action="{{ route('Delete.Speciality', $speciality->id) }}"
                                                            style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" @disabled($speciality->isDeletable())
                                                                onclick="confirmDelete('{{ $speciality->id }}')"
                                                                class="btn btn-danger btn-sm px-2"
                                                                title="{{ $speciality->isDeletable() ? 'این تخصص قابل حذف نیست' : 'حذف' }}">
                                                                <i class="fa fa-trash text-light"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if ($specialities->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">هیچ تخصصی یافت نشد!</td>
                                            </tr>
                                        @endif
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
