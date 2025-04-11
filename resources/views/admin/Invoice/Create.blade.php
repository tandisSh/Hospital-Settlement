@extends('admin.layouts.master')

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
                    <form method="GET" action="{{ route('admin.SearchInvoicePay') }}" class="mb-4">
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
                                <button type="submit" class="btn btn-primary shadow-sm w-100">
                                    جستجو
                                    <i class="fas fa-search me-1"></i>
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
                                                <th>نام پزشک</th>
                                                <th>نام بیمار</th>
                                                <th>نوع عمل</th>
                                                <th>نقش</th>
                                                <th>مبلغ سهم(تومان)</th>
                                                <th>تاریخ عمل</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <form method="POST" action="{{ route('admin.StoreInvoice') }}"
                                                id="invoice-form">
                                                @csrf
                                                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                                <input type="hidden" name="selected_total_amount" id="selected-total-amount" value="0">
                                                @foreach ($surgeries as $index => $surgery)
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" name="surgery_ids[]"
                                                                    value="{{ $surgery['id'] }}"
                                                                    class="form-check-input surgery-checkbox"
                                                                    data-amount="{{ $surgery['amount'] }}">
                                                            </div>
                                                        </td>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $doctor->name }}</td>
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
                                                        <td>{{ number_format($surgery['amount']) }}</td>
                                                        <td>{{ Jalalian::fromDateTime($surgery['surgeried_at'])->format('Y/m/d') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr class="table-light">
                                                    <td colspan="5" class="text-end fw-bold">مجموع سهم ها:</td>
                                                    <td colspan="2" class="text-success fw-bold">
                                                        {{ number_format($totalAmount) }} تومان
                                                    </td>
                                                </tr>
                                                <tr class="table-light">
                                                    <td colspan="5" class="text-end fw-bold">مجموع سهم‌های انتخاب شده:
                                                    </td>
                                                    <td colspan="2" class="text-success fw-bold"
                                                        id="total-selected-amount">
                                                        0 تومان
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        <button type="submit" class="btn btn-success" id="submit-btn"
                                                            disabled>
                                                            <i class="fas fa-file-invoice-dollar me-2"></i>
                                                            ثبت صورتحساب
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
                <div class="alert alert-warning mb-0">
                    <i class="fas fa-warning me-2"></i>
                    هیچ عمل جراحی برای این پزشک یافت نشد
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkboxes = document.querySelectorAll('.surgery-checkbox');
                const totalSelectedAmountElement = document.getElementById('total-selected-amount');
                const submitBtn = document.getElementById('submit-btn');
                const totalAmountInput = document.getElementById('selected-total-amount');

                function updateSelectedAmount() {
                    let totalSelected = 0;
                    let anyChecked = false;

                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            totalSelected += parseInt(checkbox.dataset.amount) || 0;
                            anyChecked = true;
                        }
                    });

                    totalSelectedAmountElement.textContent = totalSelected.toLocaleString() + ' تومان ';
                    totalAmountInput.value = totalSelected;
                    submitBtn.disabled = !anyChecked;
                }

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateSelectedAmount);
                });

                updateSelectedAmount();
            });
        </script>
    @endpush

@endsection
