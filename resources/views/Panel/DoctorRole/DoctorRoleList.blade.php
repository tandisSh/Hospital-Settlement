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
                                <a href="{{ route('DoctorRole.Create') }}" class="btn btn-primary btn-sm px-3">افزودن نقش جدید +</a>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center align-middle">ردیف</th>
                                            <th class="text-center align-middle">شناسه</th>
                                            <th class="text-center align-middle">عنوان</th>
                                            <th class="text-center align-middle d-none d-md-table-cell">اجباری</th>
                                            <th class="text-center align-middle d-none d-md-table-cell">سهمیه</th>
                                            <th class="text-center align-middle">وضعیت</th>
                                            <th class="text-center align-middle">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $index => $role)
                                            <tr>
                                                <td class="text-center align-middle">{{  $index + 1}}</td>
                                                <td class="text-center align-middle">{{ $role->id }}</td>
                                                <td class="text-center align-middle">{{ $role->title }}</td>
                                                <td class="text-center align-middle d-none d-md-table-cell">
                                                    <span class="badge {{ $role->required ? 'bg-info' : 'bg-secondary' }}">
                                                        {{ $role->required ? 'بله' : 'خیر' }}
                                                    </span>
                                                </td>
                                                <td class="text-center align-middle d-none d-md-table-cell">
                                                    <span class="badge bg-primary">{{ $role->quota }}%</span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge {{ $role->status ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $role->status ? 'فعال' : 'غیرفعال' }}
                                                    </span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ route('DoctorRole.Edit', $role->id) }}"
                                                            class="btn btn-warning btn-sm px-2" title="ویرایش">
                                                            <i class="fa fa-pen text-dark"></i>
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm px-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $role->id }}"
                                                            title="حذف">
                                                            <i class="fa fa-trash text-dark"></i>
                                                        </button>
                                                    </div>

                                                    <!-- Modal for Delete Confirmation -->
                                                    <div class="modal fade" id="deleteModal{{ $role->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">تأیید حذف</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    آیا از حذف نقش "{{ $role->title }}" اطمینان دارید؟
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                                                                    <form action="{{ route('DoctorRole.Delete', $role->id) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">حذف</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if ($roles->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fa fa-info-circle fa-2x mb-2"></i>
                                                        <p class="mb-0">هیچ نقشی یافت نشد!</p>
                                                    </div>
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

    @push('scripts')
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let tableRows = document.querySelectorAll('tbody tr');

            tableRows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
    @endpush
@endsection
