@extends('Panel.layouts.master')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
                        <h3 class="card-title mb-0 fs-5">جزئیات اطلاعات پزشک</h3>
                        <a href="{{ route('Doctors') }}" class="btn btn-light btn-sm py-1">
                            <i class="fas fa-arrow-right ml-1"></i>
                            بازگشت به لیست
                        </a>
                    </div>

                    <div class="card-body py-2">
                        <div class="row g-2">
                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">نام</h6>
                                    <p class="mb-0 small">{{ $doctor->name }}</p>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">تخصص</h6>
                                    <p class="mb-0 small">{{ $doctor->speciality->title }}</p>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">کد ملی</h6>
                                    <p class="mb-0 small">{{ $doctor->national_code }}</p>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">شماره نظام پزشکی</h6>
                                    <p class="mb-0 small">{{ $doctor->medical_number }}</p>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">شماره موبایل</h6>
                                    <p class="mb-0 small">{{ $doctor->mobile }}</p>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">وضعیت</h6>
                                    <p class="mb-0 small">
                                        @if($doctor->status)
                                            <span class="badge bg-success">فعال</span>
                                        @else
                                            <span class="badge bg-danger">غیرفعال</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">تاریخ ثبت</h6>
                                    <p class="mb-0 small">{{ $doctor->getCreatedAtShamsi() }}</p>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">آخرین بروزرسانی</h6>
                                    <p class="mb-0 small">{{ $doctor->getUpdatedAtShamsi() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <h5 class="fw-bold mb-2 text-primary fs-6">
                                <i class="fas fa-user-tag ml-1"></i>
                                نقش‌های پزشک
                            </h5>
                            <div class="border rounded p-2 bg-light">
                                <div class="d-flex flex-wrap gap-2">
                                    @forelse($doctor->roles as $role)
                                        <span class="badge bg-info">{{ $role->title }}</span>
                                    @empty
                                        <p class="text-muted small mb-0">هیچ نقشی تعیین نشده است.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between py-2">
                        <a href="{{ route('Doctor.Edit', $doctor->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit ml-1"></i>
                            ویرایش اطلاعات
                        </a>
                        <form action="{{ route('Doctor.Delete', $doctor->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('آیا از حذف این پزشک اطمینان دارید؟')">
                                <i class="fas fa-trash ml-1"></i>
                                حذف پزشک
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 