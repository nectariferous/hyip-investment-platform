@extends('backend.auth.master')
@section('content')
    <section class="login-page">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="admin-login-wrapper">
                        <h3 class="text-dark text-center mb-4">{{ __('Send Reset Code') }}</h3>
                        <form action="{{ route('admin.password.reset') }}" method="POST" class="cmn-form mt-30">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="text-white">{{ __('Email') }}</label>
                                <input type="email" name="email" class="form-control b-radius--capsule" id="username"
                                    value="{{ old('email') }}" placeholder="{{ __('Enter your email') }}">
                                <i class="las la-user input-icon"></i>
                            </div>
                            <div class="form-group text-right">
                                <a href="{{ route('admin.login') }}" class="text--small"><i
                                        class="fas fa-lock mr-2"></i>{{ __('Login Here') }}</a>
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="login-button text-white w-100" tabindex="4">
                                    {{ __('Send Reset Code') }}
                                </button>
                            </div>

                        </form>
                    </div>
                    <div class="simple-footer text-white">
                        {{ @$general->copyright }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
