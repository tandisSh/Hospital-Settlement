@extends('Panel.layouts.Master')

@section('content')
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <div class="row justify-content-center mt-5">
                <div class="col-lg-10">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">لیست نقش‌های پزشک</h4>
                                <a href="{{ route('DoctorRole.Create') }}" class="btn btn-warning btn-sm px-3">افزودن نقش جدید +</a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center">ردیف</th>
                                            <th class="text-center">شناسه</th>
                                            <th class="text-center">عنوان</th>
                                            <th class="text-center d-none d-md-table-cell">اجباری</th>
                                            <th class="text-center d-none d-md-table-cell">سهمیه</th>
                                            <th class="text-center">وضعیت</th>
                                            <th class="text-center">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $index => $role)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $role->id }}</td>
                                                <td class="text-center">{{ $role->title }}</td>
                                                <td class="text-center d-none d-md-table-cell">
                                                    {{ $role->required ? 'بله' : 'خیر' }}
                                                </td>
                                                <td class="text-center d-none d-md-table-cell">
                                                    {{ $role->quota }}%
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge {{ $role->status ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $role->status ? 'فعال' : 'غیرفعال' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="#" class="btn btn-info btn-sm px-2" title="مشاهده">
                                                            <i class="fa fa-eye text-dark"></i>
                                                        </a>
                                                        <a href="{{ route('DoctorRole.Edit', $role->id) }}"
                                                            class="btn btn-warning btn-sm px-2" title="ویرایش">
                                                            <i class="fa fa-pen text-dark"></i>
                                                        </a>
                                                        <button
                                                            onclick="confirmAction('{{ route('DoctorRole.Delete', $role->id) }}')"
                                                            class="btn btn-danger btn-sm px-2" title="حذف">
                                                            <i class="fa fa-trash text-dark"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if ($roles->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">هیچ نقشی یافت نشد!</td>
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
