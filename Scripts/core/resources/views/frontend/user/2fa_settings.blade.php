@extends(template().'layout.master2')

@section('content2')
    <div class="dashboard-body-part">
        <div class="row gy-4 justify-content-center">
            <div class="col-xxl-6 col-xl-8">

                <div class="card p-0">
                    <div class="card-header">
                        <h4 class="mb-0">{{ __('Two Factor Authentication') }}</h4>
                    </div>
                    <div class="card-body">
                        <p>{{ __('Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.') }}
                        </p>

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($data['user']->loginSecurity == null)
                            <form class="form-horizontal" method="POST" action="{{ route('user.generate2faSecret') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <button type="submit" class="sp_btn sp_theme_btn">
                                        {{ __('Generate Secret Key to Enable 2FA') }}
                                    </button>
                                </div>
                            </form>
                        @elseif(!$data['user']->loginSecurity->google2fa_enable)
                            {{ __(' 1. Scan this QR code with your Google Authenticator App.') }}

                            <div class="my-3">
                                <img src="<?= $data['google2fa_url'] ?>">
                            </div>

                            2. {{ __('Enter the pin from Google Authenticator app') }}:<br /><br />
                            <form class="form-horizontal" method="POST" action="{{ route('user.enable2fa') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                    <label for="secret" class="control-label">{{ __('Authenticator Code') }}</label>
                                    <input id="secret" type="password" class="form-control col-md-12 mb-3" name="secret"
                                        required>
                                    @if ($errors->has('verify-code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('verify-code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <button type="submit" class="sp_btn sp_theme_btn">
                                    {{ __('Enable 2FA') }}
                                </button>
                            </form>
                        @elseif($data['user']->loginSecurity->google2fa_enable)
                            <div class="alert alert-success">
                                {{ __(' 2FA is currently enabled on your account.') }}
                            </div>
                            <p>{{ __('If you are looking to disable Two Factor Authentication. Please confirm your password and Click Disable 2FA Button') }}.
                            </p>
                            <form class="form-horizontal" method="POST" action="{{ route('user.disable2fa') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                    <label for="change-password" class="control-label">{{ __('Current Password') }}</label>
                                    <input id="current-password" type="password" class="form-control col-md-12 mb-4"
                                        name="current-password" required>
                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('current-password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <button type="submit" class="sp_btn sp_theme_btn">{{ __('Disable 2FA') }}</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
