@extends(template().'layout.auth')
@php

$content = content('breadcrumb.content');

@endphp

@section('content')
    @push('seo')
        <meta name='description' content="{{ @$general->seo_description }}">
    @endpush

    <section class="auth-section">
        <div class="auth-wrapper">
            <div class="auth-top-part">
                <a href="{{ route('home') }}" class="auth-logo w-100 text-center">
                    <img class="img-fluid rounded sm-device-img text-align" src="{{ getFile('logo', @$general->logo) }}"
                        width="100%" alt="logo">
                </a>
            </div>

            <div class="auth-body-part">
                <div class="auth-form-wrapper">
                    @if ($general->is_email_verification_on && !auth()->user()->ev)
                        <h3 class="text-center mb-4">{{ __('Verify Email') }}</h3>
                        <form class="reg-form" action="{{route('user.authentication.verify.email')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="formGroupExampleInput"> {{ __('Verification Code') }}</label>
                                <input type="text" name="code" class="form-control"
                                    placeholder="{{ __('Enter Verification Code') }}">
                            </div>
                            @if (@$general->allow_recaptcha)
                                <div class="mb-3">
                                    <script src="https://www.google.com/recaptcha/api.js"></script>
                                    <div class="g-recaptcha" data-sitekey="{{ @$general->recaptcha_key }}"
                                        data-callback="verifyCaptcha"></div>
                                    <div id="g-recaptcha-error"></div>
                                </div>
                            @endif
                            <button class="sp_theme_btn w-100" type="submit"> {{ __('Verify Now') }} </button>
                        </form>
                    @elseif($general->is_sms_verification_on && !auth()->user()->sv)


                        <form method="POST" action="{{ route('user.authentication.verify.sms') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1"
                                    class="form-label">{{ __('Sms Verify Code') }}</label>
                                <input type="text" name="code" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>

                            <button type="submit"
                                class="sp_theme_btn w-100">{{ __('Verify Now') }}</button>

                        </form>
                    @endif
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

        <div class="auth-thumb-area">
            <div class="auth-thumb">
                <img src="{{ getFile('frontendlogin', @$general->frontend_login_image) }}" alt="image">
            </div>
        </div>
    </section>

@endsection
