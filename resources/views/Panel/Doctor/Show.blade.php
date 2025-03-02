@extends('Panel.layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">جزئیات اطلاعات پزشک</h3>
                        <a href="{{ route('Doctors') }}" class="btn btn-light">بازگشت به لیست</a>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">نام:</h6>
                                <p>{{ $doctor->name }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">تخصص:</h6>
                                <p>{{ $doctor->speciality->title }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">کد ملی:</h6>
                                <p>{{ $doctor->national_code }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">شماره نظام پزشکی:</h6>
                                <p>{{ $doctor->medical_number }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">شماره موبایل:</h6>
                                <p>{{ $doctor->mobile }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">وضعیت:</h6>
                                <p>
                                    @if($doctor->status)
                                        <span class="badge bg-success">فعال</span>
                                    @else
                                        <span class="badge bg-danger">غیرفعال</span>
                                    @endif
                                </p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">تاریخ ثبت:</h6>
                                <p>{{ $doctor->getCreatedAtShamsi() }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">آخرین بروزرسانی:</h6>
                                <p>{{ $doctor->getUpdatedAtShamsi() }}</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5 class="fw-bold mb-3">نقش‌های پزشک:</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @forelse($doctor->roles as $role)
                                    <span class="badge bg-info">{{ $role->title }}</span>
                                @empty
                                    <p class="text-muted">هیچ نقشی تعیین نشده است.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('Doctor.Edit', $doctor->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i>
                            ویرایش اطلاعات
                        </a>
                        <form action="{{ route('Doctor.Delete', $doctor->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('آیا از حذف این پزشک اطمینان دارید؟')">
                                <i class="fas fa-trash"></i>
                                حذف پزشک
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 