@extends('Panel.Layouts.Master')

@section('title', 'لیست صورتحساب‌ها')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="col-md-10">
            <div class="card mb-4 shadow-lg rounded">
                <div class="card-body">
                    <form method="GET" action="" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control shadow-sm"
                                    placeholder="جستجو بر اساس  نام پزشک" value="{{ old('search', request('search')) }}">
                                <!-- اضافه کردن سایه به فیلد ورودی -->
                            </div>

                            <div class="col-md-3">
                                <select name="status" class="form-control shadow-sm">
                                    <option value="">تمام وضعیت‌ها</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>پرداخت شده
                                    </option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>در انتظار
                                        پرداخت</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>لغو
                                        شده</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-secondary shadow">جستجو</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-4 shadow-lg rounded">
                <div
                    class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
                    <h3 class="card-title">لیست صورتحساب‌ها</h3>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped table-hover text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ردیف</th>

                                <th>نام پزشک</th>
                                <th>تاریخ</th>
                                <th>مبلغ کل</th>
                                <th>وضعیت</th>
                                <th style="width: 150px;">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $index => $invoice)
                                <tr class="align-middle">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $invoice->doctor->name }}</td>
                                    <td>{{ $invoice->getCreatedAtShamsi()->format('H:i - Y/m/d') }}</td>
                                    <td>{{ number_format($invoice->amount) }} ریال</td>
                                    <td>
                                        <span class="badge {{ $invoice->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $invoice->status ? 'پرداخت شده' : 'پرداخت نشده' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('Panel.EditInvoice', $invoice->id) }}"
                                            class="btn btn-warning btn-sm shadow-sm" style="color: white !important;"><i
                                                class="fa fa-pencil text-light"></i></a>
                                        <a href="{{ route('Panel.DeleteInvoice', $invoice->id) }}"
                                            class="btn btn-danger btn-sm shadow-sm" style="color: white !important;"><i
                                                class="fa fa-trash text-light"></i></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
