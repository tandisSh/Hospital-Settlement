@extends('Panel.layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">جزئیات جراحی</h3>
                        <a href="{{ route('surgeries') }}" class="btn btn-light">بازگشت به لیست</a>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">نام بیمار:</h6>
                                <p>{{ $surgery->patient_name }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">کد ملی بیمار:</h6>
                                <p>{{ $surgery->patient_national_code }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">شماره پرونده:</h6>
                                <p>{{ $surgery->document_number }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">تاریخ جراحی:</h6>
                                <p>{{ $surgery->getSurgeriedAtShamsi() }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">تاریخ ترخیص:</h6>
                                <p>{{ $surgery->getReleasedAtShamsi() }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">بیمه پایه:</h6>
                                <p>{{ $surgery->basicInsurance ? $surgery->basicInsurance->name : 'ندارد' }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">بیمه تکمیلی:</h6>
                                <p>{{ $surgery->suppInsurance ? $surgery->suppInsurance->name : 'ندارد' }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h5 class="fw-bold mb-3">عمل‌های انجام شده:</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>نام عمل</th>
                                            <th>هزینه</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($surgery->operations as $operation)
                                            <tr>
                                                <td>{{ $operation->name }}</td>
                                                <td>{{ number_format($operation->price) }} تومان</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h5 class="fw-bold mb-3">پزشکان:</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>نام پزشک</th>
                                            <th>تخصص</th>
                                            <th>نقش</th>
                                            <th>سهم از جراحی</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($surgery->doctors as $doctor)
                                            <tr>
                                                <td>{{ $doctor->name }}</td>
                                                <td>{{ $doctor->speciality->title }}</td>
                                                <td>
                                                    @switch($doctor->pivot->doctor_role_id)
                                                        @case(1)
                                                            جراح
                                                            @break
                                                        @case(2)
                                                            متخصص بیهوشی
                                                            @break
                                                        @case(3)
                                                            مشاور
                                                            @break
                                                    @endswitch
                                                </td>
                                                <td>{{ number_format($doctor->pivot->amount) }} تومان</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if($surgery->description)
                            <div class="mt-4">
                                <h5 class="fw-bold mb-3">توضیحات:</h5>
                                <p class="text-justify">{{ $surgery->description }}</p>
                            </div>
                        @endif

                        <div class="row mt-4">
                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">تاریخ ثبت:</h6>
                                <p>{{ $surgery->getCreatedAtShamsi() }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">آخرین بروزرسانی:</h6>
                                <p>{{ $surgery->getUpdatedAtShamsi() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('surgery.edit', $surgery->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i>
                            ویرایش اطلاعات
                        </a>
                        <form action="{{ route('surgery.delete', $surgery->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('آیا از حذف این جراحی اطمینان دارید؟')">
                                <i class="fas fa-trash"></i>
                                حذف جراحی
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
