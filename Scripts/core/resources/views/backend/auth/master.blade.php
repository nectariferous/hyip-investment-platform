<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ @$general->sitename }}</title>

    <link rel="shortcut icon" type="image/png" href="{{ getFile('icon', @$general->favicon) }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('asset/admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/font-awsome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('asset/admin/css/izitoast.min.css') }}">

    <!-- Template CSS -->

    <link rel="stylesheet" href="{{ asset('asset/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/custom.css') }}">



</head>

<body>

    <div id="app">
        <div class="main-wrapper" style="background-image: url({{ getFile('login', @$general->login_image) }})">


            @yield('content')


        </div>
    </div>


    <!-- General JS Scripts -->
    <script src="{{ asset('asset/admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/admin/modules/popper.js') }}"></script>
    <script src="{{ asset('asset/admin/js/proper.min.js') }}"></script>
    <script src="{{ asset('asset/admin/js/bootstrap.min.js') }}"></script>


    <script src="{{ asset('asset/admin/js/izitoast.min.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('asset/admin/js/stisla.js') }}"></script>
    <script src="{{ asset('asset/admin/js/scripts.js') }}"></script>


    @stack('script')



    @if (Session::has('success'))
        <script>
            "use strict";
            iziToast.success({
                message: "{{ session('success') }}",
                position: 'topRight'
            });
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            "use strict";
            iziToast.error({
                message: "{{ session('error') }}",
                position: 'topRight'
            });
        </script>
    @endif
    @if (session()->has('notify'))
        @foreach (session('notify') as $msg)
            <script>
                "use strict";
                iziToast.{{ $msg[0] }}({
                    message: "{{ trans($msg[1]) }}",
                    position: "topRight"
                });
            </script>
        @endforeach
    @endif

    @if (@$errors->any())
        <script>
            "use strict";
            @foreach ($errors->all() as $error)
                iziToast.error({
                message: '{{ __($error) }}',
                position: "topRight"
                });
            @endforeach
        </script>
    @endif


</body>

</html>
