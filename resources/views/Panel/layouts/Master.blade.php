<!doctype html>
<html lang="en" dir="rtl">

@include('Panel.layouts.Head-tag')

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    <div class="app-wrapper">
        @include('Panel.layouts.Header')
        @include('Panel.layouts.Sidebar')

        @yield('content')
        @include('Panel.layouts.Footer')
        @include('Panel.layouts.Js')
    </div>

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
