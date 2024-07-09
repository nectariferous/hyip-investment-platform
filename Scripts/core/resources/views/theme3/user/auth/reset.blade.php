@extends(template().'layout.auth')

@section('content')

    @push('seo')
        <meta name='description' content="{{ @$general->seo_description }}">
    @endpush


    <section class="auth-section">
        <div class="auth-wrapper">
            <div class="auth-top-part">
                <a href="{{ route('home') }}" class="auth-logo">
                    <img class="img-fluid rounded sm-device-img text-align" src="{{ getFile('logo', @$general->whitelogo) }}"
                        width="100%" alt="pp">
                </a>
                <p class="text-center"><span class="me-2">{{ __('Login Again') }}?</span> <a href="{{ route('user.login') }}" class="btn main-btn btn-sm" >{{ __('Login') }}</a></p>
            </div>
            <div class="auth-body-part">
                <div class="auth-form-wrapper">
                    <h3 class="text-center mb-4">{{ __('Reset Password') }}</h3>
                    <form action="{{ route('user.reset.password') }}" method="POST">
                        @csrf
                        <div class="row justify-content-center">
                            <input type="hidden" name="email" value="{{ $session['email'] }}">
                            <div class="form-group col-md-12">
                                <label for="" class="sp_text_secondary mt-2 mb-2">{{ __('New Password') }}</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter new password">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="sp_text_secondary mb-2 mt-2">{{ __('Confirm Password') }}</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                            </div>
                            @if (@$general->allow_recaptcha==1)
                                <div class="col-md-12 my-3">
                                    <script src="https://www.google.com/recaptcha/api.js"></script>
                                    <div class="g-recaptcha" data-sitekey="{{ @$general->recaptcha_key }}"
                                        data-callback="verifyCaptcha"></div>
                                    <div id="g-recaptcha-error"></div>
                                </div>
                            @endif
                            <div class="col-md-12">
                                <button type="submit" id="recaptcha"
                                    class="btn main-btn w-100 mt-3">{{ __('Reset Password') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="auth-footer-part">
                <p class="text-center mb-0">
                    @if (@$general->copyright)
                        {{ __(@$general->copyright) }}
                    @endif
                </p>
            </div>
        </div>
        <div class="auth-thumb-area" style="background-image: url('{{ asset('asset/theme3/images/bg/plan.jpg') }}')">
            <div class="auth-thumb">
                <img src="{{ getFile('frontendlogin', @$general->frontend_login_image) }}" alt="image">
            </div>
        </div>
    </section>
@endsection


@push('script')
    <script>
        "use strict";

        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =
                    "<span class='sp_text_danger'>{{__('Captcha field is required.')</span>";
                return false;
            }
            return true;
        }

        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
@endpush
