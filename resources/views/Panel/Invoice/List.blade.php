@extends('Panel.Layouts.Master')

@section('title', 'لیست صورتحساب‌ها')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">لیست صورتحساب‌ها</h4>
                        <a href="{{ route('panel.invoices.create') }}" class="btn btn-primary">
                            ایجاد صورتحساب جدید
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">ردیف</th>
                                    <th class="text-center">پزشک</th>
                                    <th class="text-center">مبلغ (ریال)</th>
                                    <th class="text-center">وضعیت</th>
                                    <th class="text-center">تاریخ ثبت</th>
                                    <th class="text-center">توضیحات</th>
                                    <th class="text-center">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $index => $invoice)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center">{{ $invoice->doctor->name }}</td>
                                        <td class="text-center">{{ number_format($invoice->amount) }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $invoice->status ? 'bg-success' : 'bg-warning' }}">
                                                {{ $invoice->status ? 'پرداخت شده' : 'در انتظار پرداخت' }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $invoice->getCreatedAtShamsi()->format('Y/m/d H:i') }}</td>
                                        <td class="text-center">{{ $invoice->description ?: '-' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="{{ route('panel.invoices.edit', $invoice->id) }}" class="btn btn-sm btn-warning">
                                                    ویرایش
                                                </a>
                                                <form action="{{ route('panel.invoices.destroy', $invoice->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('آیا از حذف این صورتحساب اطمینان دارید؟')">
                                                        حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">هیچ صورتحسابی یافت نشد</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 