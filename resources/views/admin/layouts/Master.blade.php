<!doctype html>
<html lang="en" dir="rtl">

@include('admin.layouts.Head-tag')

<head>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Persian Datepicker -->
    <link rel="stylesheet" href="{{ asset('plugins/persian-datepicker/persian-datepicker.min.css') }}">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    <div class="app-wrapper">
        @include('admin.layouts.Header')
        @include('admin.layouts.Sidebar')

        @yield('content')
        @include('admin.layouts.Footer')
        @include('admin.layouts.Js')
    </div>

    <!-- adminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- Persian Datepicker -->
    <script src="{{ asset('plugins/persian-datepicker/persian-datepicker.min.js') }}"></script>
    @stack('scripts')

    <script>
        function confirmDelete(id) {
            if (document.querySelector(`#delete-form-${id} button`).disabled) {
                return;
            }

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: "این عملیات قابل بازگشت نیست!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله، حذف شود',
                cancelButtonText: 'خیر'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>
</body>
</div>

</html>
