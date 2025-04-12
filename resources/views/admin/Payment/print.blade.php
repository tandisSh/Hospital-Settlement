@extends('admin.Layouts.Master')

@section('content')
    <div class="container mt-5">
        <div class="col-md-10 mx-auto">

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
                            <th class="text-center">عملیات</th>
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
                                <td>
                                    <button onclick="confirmAction('{{ route('admin.DestroyPayment', $item->id) }}')"
                                        class="btn btn-danger btn-sm px-2" title="حذف">
                                        <i class="fa fa-trash "></i>
                                    </button>
                                    <form id="delete-form" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4 no-print">
                <a href="{{ route('admin.InvoiceList') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> بازگشت
                </a>
            </div>
        </div>
    </div>
@endsection
