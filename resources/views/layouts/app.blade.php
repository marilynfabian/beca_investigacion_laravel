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

@stack('scripts')
</body>
</html>