@extends('admin.layouts.Master')

@section('content')
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <div class="row justify-content-center mt-5">
                <div class="col-lg-10">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">لیست جراحی‌ها</h4>
                                <a href="{{ route('surgery.create') }}" class="btn btn-primary btn-sm px-3">ثبت جراحی جدید
                                    +</a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center">ردیف</th>
                                            <th class="text-center">نام بیمار</th>
                                            <th class="text-center">کد ملی بیمار</th>
                                            <th class="text-center">تاریخ جراحی</th>
                                            <th class="text-center">تاریخ ثبت</th>
                                            <th class="text-center">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($surgeries as $index => $surgery)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $surgery->patient_name }}</td>
                                                <td class="text-center">{{ $surgery->patient_national_code }}</td>
                                                <td class="text-center">
                                                    {{ $surgery->getSurgeriedAtShamsi()->format('Y/m/d') }}</td>
                                                <td class="text-center">
                                                    {{ $surgery->getCreatedAtShamsi()->format('H:i - Y/m/d') }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ route('surgery.show', $surgery->id) }}"
                                                            class="btn btn-info btn-sm px-2" title="مشاهده جزییات">
                                                            <i class="fa fa-eye text-light"></i>
                                                        </a>
                                                        <a href="{{ route('surgery.edit', $surgery->id) }}"
                                                            class="btn btn-warning btn-sm px-2" title="ویرایش">
                                                            <i class="fa fa-pen text-lightb2"></i>
                                                        </a>
                                                        <button
                                                            onclick="confirmAction('{{ route('surgery.delete', $surgery->id) }}')"
                                                            class="btn btn-danger btn-sm px-2" title="حذف">
                                                            <i class="fa fa-trash "></i>
                                                        </button>
                                                        <form id="delete-form" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if ($surgeries->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">هیچ جراحی‌ای یافت نشد!
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
