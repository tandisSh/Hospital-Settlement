@extends('admin.Layouts.Master')

@section('title', 'ثبت پرداخت')

@section('content')
    <div class="container mt-5">
        <div class="col-md-10 mx-auto">

            <div class="card shadow-sm mb-4 border-primary">
                <div class="card-body py-3">
                    <div class="row text-center">
                        <div class="col-md-4 border-end">
                            <h6 class="text-muted mb-2">مبلغ کل صورتحساب</h6>
                            <h4 class="text-primary fw-bold">{{ number_format($invoice->amount) }} تومان</h4>
                        </div>
                        <div class="col-md-4 border-end">
                            <h6 class="text-muted mb-2">مجموع پرداخت‌ها</h6>
                            <h4 class="text-success fw-bold">{{ number_format($totalPaid) }} تومان</h4>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-2">مبلغ باقیمانده</h6>
                            <h4 class="{{ $remainingAmount > 0 ? 'text-danger' : 'text-success' }} fw-bold">
                                {{ number_format($remainingAmount) }} تومان
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg rounded">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        ثبت پرداخت برای صورتحساب:
                        <span class="fw-bold">{{ $invoice->doctor->name }}</span>
                    </h5>
                </div>

                @if ($invoice->status)
                    <div class="alert alert-success m-3">
                        این صورتحساب قبلاً تسویه شده است و امکان ثبت پرداخت جدید وجود ندارد.
                    </div>
                @else
                    <div class="card-body">
                        <ul class="nav nav-pills mb-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="pill" href="#cash" role="tab">پرداخت نقدی</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" href="#cheque" ro le="tab">پرداخت چکی</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            {{-- نقدی --}}
                            <div class="tab-pane fade show active" id="cash" role="tabadmin">
                                <form method="POST" action="{{ route('admin.StoreCashPayment') }}" enctype="multipart/form-data" id="cashForm">
                                    @csrf
                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>شماره فیش</label>
                                            <input type="text" name="receipt_number" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label>مبلغ (حداکثر {{ number_format($remainingAmount) }} تومان)</label>
                                            <input type="number"
                                                   name="amount"
                                                   class="form-control"
                                                   required
                                                   min="1000"
                                                   step="1000"
                                                   max="{{ $remainingAmount }}"
                                                   oninput="validateAmount(this, {{ $remainingAmount }})">
                                            @error('amount')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>عکس رسید</label>
                                            <input type="file" name="receipt" class="form-control" accept="image/*" required>
                                            <small class="text-muted">فرمت‌های مجاز: jpg, png (حداکثر 2MB)</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label>توضیحات</label>
                                        <textarea name="description" class="form-control" rows="2"></textarea>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="fas fa-check-circle me-2"></i>
                                            ثبت پرداخت نقدی
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- چکی --}}
                            <div class="tab-pane fade" id="cheque" role="tabadmin">
                                <form method="POST" action="{{ route('admin.StoreChequePayment') }}" enctype="multipart/form-data" id="chequeForm">
                                    @csrf
                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>شماره چک</label>
                                            <input type="text" name="cheque_number" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label>مبلغ (حداکثر {{ number_format($remainingAmount) }} تومان)</label>
                                            <input type="number"
                                                   name="amount"
                                                   class="form-control"
                                                   required
                                                   min="1000"
                                                   step="1000"
                                                   max="{{ $remainingAmount }}"
                                                   oninput="validateAmount(this, {{ $remainingAmount }})">
                                            @error('amount')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>تاریخ چک</label>
                                            <input type="text" name="due_date" class="form-control" data-jdp value="{{ \Morilog\Jalali\Jalalian::now()->format('Y/m/d') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label>تصویر چک</label>
                                            <input type="file" name="receipt" class="form-control" accept="image/*" required>
                                            <small class="text-muted">فرمت‌های مجاز: jpg, png (حداکثر 2MB)</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label>توضیحات</label>
                                        <textarea name="cheque_description" class="form-control" rows="2"></textarea>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info px-4">
                                            <i class="fas fa-file-invoice me-2"></i>
                                            ثبت پرداخت چکی
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function validateAmount(input, maxAmount) {
            const value = parseInt(input.value);

            if (isNaN(value)) {
                input.setCustomValidity('لطفا یک عدد معتبر وارد کنید');
                return;
            }

            if (value < 1000) {
                input.setCustomValidity('مبلغ پرداختی نمی‌تواند کمتر از 1,000 تومان باشد');
            } else if (value > maxAmount) {
                input.setCustomValidity('مبلغ پرداختی نمی‌تواند بیشتر از ' + new Intl.NumberFormat().format(maxAmount) + ' تومان باشد');
            } else {
                input.setCustomValidity('');
            }

            input.reportValidity();
        }

        // اعتبارسنجی فرم‌ها قبل از ارسال
        document.getElementById('cashForm')?.addEventListener('submit', function(e) {
            const amountInput = this.querySelector('input[name="amount"]');
            validateAmount(amountInput, {{ $remainingAmount }});

            if (!this.checkValidity()) {
                e.preventDefault();
            }
        });

        document.getElementById('chequeForm')?.addEventListener('submit', function(e) {
            const amountInput = this.querySelector('input[name="amount"]');
            validateAmount(amountInput, {{ $remainingAmount }});

            if (!this.checkValidity()) {
                e.preventDefault();
            }
        });
    </script>
@endsection
