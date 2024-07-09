@extends('backend.auth.master')

@section('content')
    <div id="app">

        <section class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-4">


                        <div class="card card-primary login">
                            <div class="card-header">
                                <h4 class="text-white">{{ __('Reset Your Password') }}</h4>
                            </div>

                            <div class="card-body">



                                <form action="{{ route('admin.password.change') }}" method="POST" class="cmn-form mt-30">
                                    @csrf

                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group">
                                        <label for="pass" class="text-white">{{ __('New Password') }}</label>
                                        <input type="password" name="password" class="form-control b-radius--capsule"
                                            id="password" placeholder="New password">
                                        <i class="las la-lock input-icon"></i>
                                    </div>
                                    <div class="form-group">
                                        <label for="pass" class="text-white">{{ __('Retype New Password') }}</label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control b-radius--capsule" id="password_confirmation"
                                            placeholder="Retype New password">
                                        <i class="las la-lock input-icon"></i>
                                    </div>

                                    <div class="form-group">
                                        <a href="{{ route('admin.login') }}" class="text-white text--small"><i
                                                class="las la-lock"></i>{{ __('Login Here') }}</a>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="login-button text-white" tabindex="4">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="simple-footer text-white">
                            {{ @$general->copyright }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
