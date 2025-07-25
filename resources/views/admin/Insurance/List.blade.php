@extends('admin.layouts.Master')

@section('content')
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <div class="row justify-content-center mt-5">
                <div class="col-lg-10">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">لیست بیمه‌ها</h4>
                                <a href="{{ route('insurances.create') }}" class="btn btn-primary btn-sm px-3">
                                    افزودن بیمه جدید +
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center">ردیف</th>
                                            <th class="text-center">شناسه</th>
                                            <th class="text-center">نام</th>
                                            <th class="text-center">نوع</th>
                                            <th class="text-center">درصد تخفیف</th>
                                            <th class="text-center">وضعیت</th>
                                            <th class="text-center">تاریخ ثبت</th>
                                            <th class="text-center">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($insurances as $index => $insurance)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $insurance->id }}</td>
                                                <td class="text-center">{{ $insurance->name }}</td>
                                                <td class="text-center">
                                                    {{ $insurance->type == 'basic' ? 'پایه' : 'تکمیلی' }}
                                                </td>
                                                <td class="text-center">{{ $insurance->discount }}%</td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge {{ $insurance->status ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $insurance->status ? 'فعال' : 'غیرفعال' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    {{ $insurance->getCreatedAtShamsi()->format('H:i - Y/m/d') }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ route('insurances.edit', $insurance->id) }}"
                                                            class="btn btn-warning btn-sm px-2" title="ویرایش">
                                                            <i class="fa fa-pen text-light"></i>
                                                        </a>
                                                        <form id="delete-form-{{ $insurance->id }}" method="POST"
                                                            action="{{ route('insurances.delete', $insurance->id) }}"
                                                            style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" @disabled($insurance->isDeletable())
                                                                onclick="confirmDelete('{{ $insurance->id }}')"
                                                                class="btn btn-danger btn-sm px-2"
                                                                title="{{ $insurance->isDeletable() ? 'این بیمه قابل حذف نیست' : 'حذف' }}">
                                                                <i class="fa fa-trash text-light"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if ($insurances->isEmpty())
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">هیچ بیمه‌ای یافت نشد!</td>
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
