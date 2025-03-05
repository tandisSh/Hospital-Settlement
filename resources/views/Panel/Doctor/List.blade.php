@extends('Panel.layouts.Master')

@section('content')
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <div class="row justify-content-center mt-5">
                <div class="col-lg-10">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">لیست پزشکان</h4>
                                <a href="{{ route('Doctor.Create') }}" class="btn btn-primary btn-sm px-3">افزودن پزشک جدید
                                    +</a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center">ردیف</th>
                                            <th class="text-center">نام</th>
                                            <th class="text-center">تخصص</th>
                                            <th class="text-center">شماره موبایل</th>
                                            <th class="text-center">وضعیت</th>
                                            <th class="text-center">تاریخ ثبت</th>
                                            <th class="text-center">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($doctors as $index => $doctor)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $doctor->name }}</td>
                                                <td class="text-center">{{ $doctor->speciality->title }}</td>
                                                <td class="text-center">{{ $doctor->mobile }}</td>
                                                <td class="text-center">
                                                    <span class="badge {{ $doctor->status ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $doctor->status ? 'فعال' : 'غیرفعال' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">{{ $doctor->getCreatedAtShamsi()->format('H:i - Y/m/d') }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ route('Doctor.Show', $doctor->id) }}"
                                                            class="btn btn-info btn-sm px-2" title="مشاهده">
                                                            <i class="fa fa-eye text-light"></i>
                                                        </a>
                                                        <a href="{{ route('Doctor.Edit', $doctor->id) }}"
                                                            class="btn btn-warning btn-sm px-2" title="ویرایش">
                                                            <i class="fa fa-pen text-light"></i>
                                                        </a>
                                                        <form id="delete-form-{{ $doctor->id }}" method="POST"
                                                            action="{{ route('Doctor.Delete', $doctor->id) }}"
                                                            style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" @disabled($doctor->isDeletable())
                                                                onclick="confirmDelete('{{ $doctor->id }}')"
                                                                class="btn btn-danger btn-sm px-2"
                                                                title="{{ $doctor->isDeletable() ? 'این عمل قابل حذف نیست' : 'حذف' }}">
                                                                <i class="fa fa-trash text-light"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if ($doctors->isEmpty())
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">هیچ پزشکی یافت نشد!</td>
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
