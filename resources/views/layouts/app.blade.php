<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">

    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css?v=3.2.0') }}">
</head>

<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ URL::to('/') }}"><b>Matrix</b> DB Event</a>
        </div>

        @yield('content')
    </div>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>  

    {{-- <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}

    <script src="{{ asset('dist/js/adminlte.min.js?v=3.2.0') }}"></script>


    <script>
        function togglePassword(id, element) {
            const password = document.getElementById(id);
            if (password.type === "password") {
                password.type = "text";
                element.innerHTML = '<i class="fa fa-eye"></i>';
            } else {
                password.type = "password";
                element.innerHTML = '<i class="fa fa-eye-slash"></i>';
            }
        }
    </script>
</body>

</html>
