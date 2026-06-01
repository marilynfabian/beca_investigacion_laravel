<!-- app.blade -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UATF</title>

    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Custom Theme -->
    <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="nav-md">

<div class="container body">
    <div class="main_container">

        {{-- SIDEBAR --}}
        @include('partials.sidebar')

        {{-- TOPBAR --}}
        @include('partials.topbar')

        {{-- CONTENIDO DINÁMICO --}}
        <div class="right_col" role="main">
            @yield('content')
        </div>

        {{-- FOOTER --}}
        @include('partials.footer')

    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- Custom Theme -->
<script src="{{ asset('build/js/custom.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('#sidebar-menu li > a').forEach(function (link) {
        const submenu = link.parentElement.querySelector(':scope > ul.child_menu');

        if (!submenu) return;

        link.addEventListener('click', function (event) {
            event.preventDefault();

            const parentLi = link.parentElement;
            const isOpen = parentLi.classList.contains('active');

            if (isOpen) {
                parentLi.classList.remove('active');
                submenu.style.display = 'none';
            } else {
                parentLi.classList.add('active');
                submenu.style.display = 'block';
            }
        });
    });
});
</script>
@stack('scripts')
</body>
</html>