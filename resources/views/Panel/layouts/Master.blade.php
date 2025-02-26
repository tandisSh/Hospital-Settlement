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
</body>
</div>

</html>
