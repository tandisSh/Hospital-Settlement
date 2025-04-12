@extends('admin.layouts.Master')

@section('content')
    <main class="app-main">
        <div class="row justify-content-center my-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body">
                        <h5>تعداد دکترها</h5>
                        <h2>{{ $doctorCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white text-center">
                    <div class="card-body">
                        <h5>تعداد صورتحساب‌ها</h5>
                        <h2>{{ $invoiceCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white text-center">
                    <div class="card-body">
                        <h5>تعداد جراحی‌ها</h5>
                        <h2>{{ $surgeryCount }}</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- جدول چک‌های نزدیک به سررسید --}}
        <div class="row mt-4 justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0">چک‌های نزدیک به سررسید</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped m-0">
                            <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>شماره چک</th>
                                    <th>پزشک</th>
                                    <th>مبلغ</th>
                                    <th>تاریخ ثبت</th>
                                    <th>تاریخ سررسید</th>
                                    <th>وضعیت</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($upcomingChecks as $index => $check)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $check->id }}</td>
                                        <td>{{ optional($check->invoice->doctor)->name ?? '---' }}</td>
                                        <td>{{ number_format($check->amount) }}</td>
                                        <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($check->created_at)->format('Y/m/d') }}
                                        </td>
                                        <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($check->due_date)->format('Y/m/d') }}
                                        </td>
                                        <td>
                                            <span class="badge {{ $check->status ? 'bg-success' : 'bg-danger' }}">
                                                {{ $check->status ? 'پاس شده' : 'در انتظار' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">چکی یافت نشد.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
