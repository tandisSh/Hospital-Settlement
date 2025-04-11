<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>چاپ صورتحساب - {{ $invoice->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="p-3">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="row mb-3 justify-content-center">
                <div class="col-md-6">
                    <p class="mb-1"><strong>نام پزشک:</strong> {{ $invoice->doctor->name }}</p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="mb-1"><strong>شماره صورتحساب:</strong> {{ $invoice->id }}</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">شناسه عمل</th>
                            <th class="text-center">نام بیمار</th>
                            <th class="text-center">نوع عمل</th>
                            <th class="text-center">تاریخ عمل</th>
                            <th class="text-center">تاریخ ترخیص</th>
                            <th class="text-center">سهم پزشک</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surgeryData as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->surgery_id }}</td>
                                <td>{{ $item->patient_name }}</td>
                                <td>{{ $item->operation_name }}</td>
                                <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($item->surgeried_at)->format('Y/m/d') }}
                                </td>
                                <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($item->released_at)->format('Y/m/d') }}
                                </td>
                                <td>{{ number_format($item->amount) }} ریال</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
            <div class="row mt-3">
                <div class="col-md-6">
                    <p><strong>جمع کل:</strong> {{ number_format($surgeryData->sum('amount')) }} ریال</p>
                </div>
                <div class="col-md-6 text-end">
                    <p><strong>تاریخ چاپ:</strong> {{ \Morilog\Jalali\Jalalian::now()->format('Y/m/d') }}</p>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4 no-print">
                <button onclick="window.print()" class="btn btn-primary me-2">
                    <i class="fas fa-print me-2"></i> چاپ صورتحساب
                </button>
                <a href="{{ route('admin.InvoiceList') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> بازگشت
                </a>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
