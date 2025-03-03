@extends('Panel.layouts.Master')

@section('content')
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <div class="row justify-content-center mt-5">
                <div class="col-lg-10">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">لیست عمل پزشکی</h4>
                                <a href="{{ route('operations.create') }}" class="btn btn-primary btn-sm px-3">
                                    افزودن عمل جدید +
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center">ردیف</th>
                                            <th class="text-center">شناسه</th>
                                            <th class="text-center">نام</th>
                                            <th class="text-center">مبلغ (تومان)</th>
                                            <th class="text-center">وضعیت</th>
                                            <th class="text-center">تاریخ ثبت</th>
                                            <th class="text-center">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($operations as $index => $operation)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $operation->id }}</td>
                                                <td class="text-center">{{ $operation->name }}</td>
                                                <td class="text-center">{{ number_format($operation->price) }}</td>
                                                <td class="text-center">
                                                    <span class="badge {{ $operation->status ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $operation->status ? 'فعال' : 'غیرفعال' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">{{ $operation->getCreatedAtShamsi()->format('Y/m/d') }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ route('operations.edit', $operation->id) }}"
                                                            class="btn btn-warning btn-sm px-2" title="ویرایش">
                                                            <i class="fa fa-pen text-dark"></i>
                                                        </a>
                                                        <form id="delete-form-{{ $operation->id }}" method="POST" action="{{ route('operations.delete', $operation->id) }}" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" 
                                                                @disabled($operation->isDeletable()) 
                                                                onclick="confirmDelete('{{ $operation->id }}')" 
                                                                class="btn btn-danger btn-sm px-2" 
                                                                title="{{ $operation->isDeletable() ? 'این عمل قابل حذف نیست' : 'حذف' }}">
                                                                <i class="fa fa-trash text-light"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if ($operations->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">هیچ عملی یافت نشد!</td>
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
