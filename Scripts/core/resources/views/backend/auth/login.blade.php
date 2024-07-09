@extends('backend.auth.master')

@section('content')
    <section class="login-page">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="admin-login-wrapper">
                        <h3 class="text-dark text-center mb-4">{{ __('Sign in to Admin') }}</h3>
                        <form method="POST" class="p-2" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input id="email" type="email" class="form-control" name="email"
                                    value="{{ old('email') }}" tabindex="1" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label ">{{ __('Password') }}</label>
                                </div>
                                <input id="password" type="password" class="form-control" name="password" tabindex="2"
                                    placeholder="Enter password" required>
                            </div>
                            <div class="d-flex justify-content-between form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                        id="remember-me">
                                    <label class="custom-control-label text-dark"
                                        for="remember-me">{{ __('Remember Me') }}</label>
                                </div>
                                <a href="{{ route('admin.password.reset') }}" class="text-small ">
                                    {{ __('Forgot Password') }}?
                                </a>
                            </div>
                            <button type="submit" class="login-button w-100" tabindex="4">
                                {{ __('Login ') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
