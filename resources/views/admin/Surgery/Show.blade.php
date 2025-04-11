@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
                        <h3 class="card-title mb-0 fs-5">جزئیات جراحی</h3>
                        <a href="{{ route('surgeries') }}" class="btn btn-light btn-sm py-1">
                            <i class="fas fa-arrow-right ml-1"></i>
                            بازگشت به لیست
                        </a>
                    </div>

                    <div class="card-body py-2">
                        <div class="row g-2">
                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">نام بیمار</h6>
                                    <p class="mb-0 small">{{ $surgery->patient_name }}</p>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">کد ملی بیمار</h6>
                                    <p class="mb-0 small">{{ $surgery->patient_national_code }}</p>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">شماره پرونده</h6>
                                    <p class="mb-0 small">{{ $surgery->document_number }}</p>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">تاریخ جراحی</h6>
                                    <p class="mb-0 small">{{ $surgery->getSurgeriedAtShamsi() }}</p>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">تاریخ ترخیص</h6>
                                    <p class="mb-0 small">{{ $surgery->getReleasedAtShamsi() }}</p>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">بیمه پایه</h6>
                                    <p class="mb-0 small">{{ $surgery->basicInsurance ? $surgery->basicInsurance->name : 'ندارد' }}</p>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="border rounded p-2 h-100 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">بیمه تکمیلی</h6>
                                    <p class="mb-0 small">{{ $surgery->suppInsurance ? $surgery->suppInsurance->name : 'ندارد' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <h5 class="fw-bold mb-2 text-primary fs-6">
                                <i class="fas fa-procedures ml-1"></i>
                                عمل‌های انجام شده
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="small">نام عمل</th>
                                            <th class="small">هزینه (تومان)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($surgery->operations as $operation)
                                            <tr>
                                                <td class="small">{{ $operation->name }}</td>
                                                <td class="small">{{ number_format($operation->pivot->amount) }} </td>
                                            </tr>
                                        @endforeach
                                        <tr class="table-primary">
                                            <td class="fw-bold small">مجموع هزینه عمل‌ها</td>
                                            <td class="fw-bold small">{{ number_format($surgery->operations->sum('pivot.amount')) }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-3">
                            <h5 class="fw-bold mb-2 text-primary fs-6">
                                <i class="fas fa-user-md ml-1"></i>
                                پزشکان
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="small">نام پزشک</th>
                                            <th class="small">نقش</th>
                                            <th class="small">سهم از جراحی (تومان)</th>
                                            <th class="small">صورتحساب</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($surgery->doctors as $doctor)
                                            <tr>
                                                <td class="small">{{ $doctor->name }}</td>
                                                <td class="small">
                                                    @switch($doctor->pivot->doctor_role_id)
                                                        @case(2)
                                                            <span class="small">جراح</span>
                                                            @break
                                                        @case(1)
                                                            <span class="small">متخصص بیهوشی</span>
                                                            @break
                                                        @case(3)
                                                            <span class="small">مشاور</span>
                                                            @break
                                                    @endswitch
                                                </td>
                                                <td class="small">{{ number_format($doctor->pivot->amount) }} </td>
                                                <td class="small">
                                                    <span class="badge {{ $doctor->pivot->invoice_id ? 'bg-success' : 'bg-warning text-dark' }}">
                                                        {{ $doctor->pivot->invoice_id ? 'ثبت شده' : 'ثبت نشده' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if($surgery->description)
                            <div class="mt-3">
                                <h5 class="fw-bold mb-2 text-primary fs-6">
                                    <i class="fas fa-info-circle ml-1"></i>
                                    توضیحات
                                </h5>
                                <div class="border rounded p-2 bg-light">
                                    <p class="text-justify mb-0 small">{{ $surgery->description }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="row mt-3 g-2">
                            <div class="col-md-6">
                                <div class="border rounded p-2 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">تاریخ ثبت</h6>
                                    <p class="mb-0 small">{{ $surgery->getCreatedAtShamsi() }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="border rounded p-2 bg-light">
                                    <h6 class="fw-bold text-primary small mb-1">آخرین بروزرسانی</h6>
                                    <p class="mb-0 small">{{ $surgery->getUpdatedAtShamsi() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between py-2">
                        <a href="{{ route('surgery.edit', $surgery->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit ml-1"></i>
                            ویرایش اطلاعات
                        </a>
                        <form action="{{ route('surgery.delete', $surgery->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('آیا از حذف این جراحی اطمینان دارید؟')">
                                <i class="fas fa-trash ml-1"></i>
                                حذف جراحی
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
