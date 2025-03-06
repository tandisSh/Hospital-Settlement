@extends('Panel.layouts.master')

@php
use Morilog\Jalali\Jalalian;
@endphp

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="col-md-10">
            <div class="card mb-4 shadow-lg rounded">
                <div class="card-header bg-white text-dark rounded-top">
                    <div class="card-title d-flex align-items-center">
                        <i class="fas fa-search me-2"></i>
                        جستجوی اعمال جراحی
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('Panel.SearchInvoicePay') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="doctor_id" class="form-label fw-bold text-dark">نام پزشک</label>
                                <select name="doctor_id" id="doctor_id" class="form-control shadow-sm">
                                    <option value="">انتخاب کنید</option>
                                    @foreach ($doctors as $d)
                                        <option value="{{ $d->id }}"
                                            {{ isset($doctor) && $doctor->id == $d->id ? 'selected' : '' }}>
                                            {{ $d->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="start_date" class="form-label fw-bold text-dark">از تاریخ</label>
                                <input type="text" name="start_date" class="form-control shadow-sm" id="start_date"
                                    data-jdp placeholder="مثال: 1402/09/15"
                                    value="{{ old('start_date', request('start_date')) }}">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label fw-bold text-dark">تا تاریخ</label>
                                <input type="text" name="end_date" class="form-control shadow-sm" id="end_date" data-jdp
                                    placeholder="مثال: 1402/09/20" value="{{ old('end_date', request('end_date')) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark">&nbsp;</label>
                                <button type="submit" class="btn btn-secondary shadow-sm w-100">
                                    <i class="fas fa-search me-1"></i>جستجو
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (isset($showSurgeryList) && $showSurgeryList)
                <div class="card mb-4 shadow-lg rounded">
                    <div class="card-header bg-primary text-white rounded-top">
                        <div class="card-title d-flex align-items-center">
                            <i class="fas fa-user-md me-2"></i>
                            اطلاعات جراحی
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-procedures me-2"></i>لیست اعمال جراحی
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>انتخاب</th>
                                                <th>ردیف</th>
                                                <th>نام بیمار</th>
                                                <th>نوع عمل</th>
                                                <th>نقش</th>
                                                <th>مبلغ سهم</th>
                                                <th>تاریخ عمل</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <form method="POST" action="{{ route('Panel.StoreInvoice') }}"
                                                id="invoice-form">
                                                @csrf
                                                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                                <input type="hidden" name="total_amount" value="{{ $totalAmount }}">
                                                @foreach ($surgeries as $index => $surgery)
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" name="surgery_ids[]"
                                                                    value="{{ $surgery['id'] }}"
                                                                    class="form-check-input surgery-checkbox">
                                                            </div>
                                                        </td>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $surgery['patient_name'] }}</td>
                                                        <td>
                                                            @if ($surgery['operations'] && count($surgery['operations']) > 0)
                                                                @foreach ($surgery['operations'] as $operation)
                                                                    <span
                                                                        class="badge bg-info me-1">{{ $operation->name }}</span>
                                                                @endforeach
                                                            @else
                                                                <span class="text-muted">تعیین نشده</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge bg-secondary">{{ $surgery['role_name'] }}</span>
                                                        </td>
                                                        <td>{{ number_format($surgery['amount'])}}</td>
                                                        <td>{{ Jalalian::fromDateTime($surgery['surgeried_at'])->format('Y/m/d') }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr class="table-light">
                                                    <td colspan="5" class="text-end fw-bold">مجموع دریافتی:</td>
                                                    <td colspan="2" class="text-success fw-bold">
                                                        {{ number_format($totalAmount) }} ریال
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        <button type="submit" class="btn btn-success" id="submit-btn"
                                                            disabled>
                                                            <i class="fas fa-file-invoice-dollar me-2"></i>
                                                            پرداخت صورتحساب
                                                        </button>
                                                    </td>
                                                </tr>

                                            </form>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(isset($doctor))
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    هیچ عملیات جراحی برای این پزشک یافت نشد
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('invoice-form');
                const submitBtn = document.getElementById('submit-btn');
                const checkboxes = document.querySelectorAll('.surgery-checkbox');

                // Enable/disable submit button based on checkbox selection
                function updateSubmitButton() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    submitBtn.disabled = !anyChecked;
                }

                // Add change event listener to all checkboxes
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateSubmitButton);
                });

                // Form submission handler
                form.addEventListener('submit', function(e) {
                    const checkedBoxes = Array.from(checkboxes).filter(cb => cb.checked);
                    if (checkedBoxes.length === 0) {
                        e.preventDefault();
                        alert('لطفا حداقل یک عمل را انتخاب کنید');
                        return false;
                    }
                });
            });
        </script>
    @endpush

@endsection
