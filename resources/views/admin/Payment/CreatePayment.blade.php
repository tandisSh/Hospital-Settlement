@extends('admin.Layouts.Master')

@section('title', 'ثبت پرداخت')

@section('content')
    <div class="container mt-5">
        <div class="col-md-10 mx-auto">

            <!-- خلاصه وضعیت پرداخت -->
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

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>لیست پرداخت ها</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">مبلغ عمل</th>
                            <th class="text-center">نوع پرداخت</th>
                            <th class="text-center">تاریخ پرداخت</th>
                            <th class="text-center">تاریخ ثبت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->payments as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->amount }}</td>
                                <td>{{ $item->pay_type === 'cash' ? 'نقدی' : 'چکی' }}</td>
                                <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($item->due_date)->format('Y/m/d') }}</td>
                                <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($item->updated_at)->format('Y/m/d') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                        <form method="POST" action="{{ route('admin.StorePayment') }}" enctype="multipart/form-data"
                            id="paymentForm">
                            @csrf
                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                            <!-- انتخاب نوع پرداخت -->
                            <div class="row mb-4">
                                <div class="col-md-6 mx-auto">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pay_type" id="cashPayment"
                                            value="cash" checked>
                                        <label class="form-check-label" for="cashPayment">پرداخت نقدی</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pay_type" id="chequePayment"
                                            value="cheque">
                                        <label class="form-check-label" for="chequePayment">پرداخت چکی</label>
                                    </div>
                                </div>
                            </div>

                            <!-- فیلدهای مشترک -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>مبلغ (حداکثر {{ number_format($remainingAmount) }} تومان)</label>
                                    <input type="number" name="amount" class="form-control" required min="1000"
                                        step="1000" max="{{ $remainingAmount }}"
                                        oninput="validateAmount(this, {{ $remainingAmount }})">
                                    @error('amount')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label>تصویر رسید</label>
                                    <input type="file" name="receipt" class="form-control" accept="image/*">
                                    <small class="text-muted">فرمت‌های مجاز: jpg, png (حداکثر 2MB)</small>
                                    @error('receipt')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- فیلدهای نقدی -->
                            <div id="cashFields">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>شماره فیش</label>
                                        <input type="number" name="receipt_number" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- فیلدهای چکی -->
                            <div id="chequeFields" style="display: none;">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>شماره چک</label>
                                        <input type="number" name="cheque_number" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>تاریخ چک</label>
                                        <input type="text" name="due_date" class="form-control" data-jdp
                                            value="{{ \Morilog\Jalali\Jalalian::now()->format('Y/m/d') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>توضیحات</label>
                                <textarea name="description" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-check-circle me-2"></i>
                                    ثبت پرداخت
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // نمایش/پنهان کردن فیلدها بر اساس نوع پرداخت
        document.querySelectorAll('input[name="pay_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('cashFields').style.display =
                    this.value === 'cash' ? 'block' : 'none';
                document.getElementById('chequeFields').style.display =
                    this.value === 'cheque' ? 'block' : 'none';
            });
        });

        function validateAmount(input, maxAmount) {
            const value = parseInt(input.value);

            if (isNaN(value)) {
                input.setCustomValidity('لطفا یک عدد معتبر وارد کنید');
                return;
            }

            if (value < 1000) {
                input.setCustomValidity('مبلغ پرداختی نمی‌تواند کمتر از 1,000 تومان باشد');
            } else if (value > maxAmount) {
                input.setCustomValidity('مبلغ پرداختی نمی‌تواند بیشتر از ' + new Intl.NumberFormat().format(maxAmount) +
                    ' تومان باشد');
            } else {
                input.setCustomValidity('');
            }

            input.reportValidity();
        }

        // اعتبارسنجی فرم قبل از ارسال
        document.getElementById('paymentForm')?.addEventListener('submit', function(e) {
            const amountInput = this.querySelector('input[name="amount"]');
            validateAmount(amountInput, {{ $remainingAmount }});

            if (!this.checkValidity()) {
                e.preventDefault();
            }
        });
    </script>
@endsection
