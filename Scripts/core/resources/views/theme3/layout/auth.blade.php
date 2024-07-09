<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/png" href="{{ getFile('icon', @$general->favicon) }}">

    <title>
        @if (@$general->sitename)
            {{ __(@$general->sitename) . '-' }}
        @endif
        {{ __(@$pageTitle) }}
    </title>

    <link rel="stylesheet" href="{{ asset('asset/theme3/frontend/css/cookie.css') }}">
    <link href="{{ asset('asset/theme3/frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/theme3/frontend/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/theme3/frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/theme3/frontend/css/font-awsome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/theme3/frontend/css/iziToast.min.css') }}">
    <link href="{{ asset('asset/theme3/frontend/css/style.css') }}" rel="stylesheet">
    @stack('style')

    <link rel="stylesheet" href="{{ asset('asset/theme1/frontend/css/color.php?primary_color=' . str_replace('#', '', @$general->primary_color)) }}">
</head>

<body>
    @if (@$general->preloader_status)
        <div id="preloader"></div>
    @endif

    @if (@$general->allow_modal)
        @include('cookieConsent::index')
    @endif


    @if (@$general->analytics_status)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ @$general->analytics_key }}"></script>
        <script>
            'use strict'
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag("js", new Date());
            gtag("config", "{{ @$general->analytics_key }}");
        </script>
    @endif

    <main id="main" class="main-img">
        @yield('content')
    </main>

    <script src="{{ asset('asset/theme3/frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/theme3/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('asset/theme3/frontend/js/slick.min.js') }}"></script>

    <script src="{{ asset('asset/theme3/frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset('asset/theme3/frontend/js/jquery.paroller.min.js') }}"></script>
    <script src="{{ asset('asset/theme3/frontend/js/TweenMax.min.js') }}"></script>

    <script src="{{ asset('asset/theme3/frontend/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('asset/theme3/frontend/js/main.js') }}"></script>
    <script src="{{ asset('asset/theme3/frontend/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('asset/theme3/frontend/js/jquery.uploadPreview.min.js') }}"></script>

    @stack('script')
    @if (@$general->twak_allow)
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = "https://embed.tawk.to/{{ @$general->twak_key }}";
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
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

    @if (Session::has('success'))
        <script>
            "use strict";
            iziToast.success({
                message: "{{ session('success') }}",
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
                message: "{{ __($error) }}",
                position: "topRight"
                });
            @endforeach
        </script>
    @endif


    <script>
        'use strict';
        


        $(document).ready(function() {
            $('#trial_subscribe').on('click', function(e) {

                e.preventDefault();
                var email = $('#trial_email').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    method: 'POST',
                    url: "{{ route('subscribe') }}",
                    data: {
                        email: email
                    },
                    success: function(response) {

                        if (response.fails) {
                            notify('error', response.errorMsg.email)

                        }

                        if (response.success) {
                            $('#email').val('');
                            notify('success', response.successMsg)

                        }
                    }
                });
            })


        });
    </script>


    <script>
        'use strict'
        var url = "{{ route('user.changeLang') }}";

        $(".changeLang").change(function() {
            if ($(this).val() == '') {
                return false;
            }
            window.location.href = url + "?lang=" + $(this).val();
        });
        //Get the button
        let mybutton = document.getElementById("btn-back-to-top");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (
                document.body.scrollTop > 20 ||
                document.documentElement.scrollTop > 20
            ) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        // When the user clicks on the button, scroll to the top of the document
        mybutton.addEventListener("click", backToTop);

        function backToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>


</body>


</html>
