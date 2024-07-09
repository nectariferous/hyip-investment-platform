@extends(template().'layout.master2')


@section('content2')
<div class="dashboard-body-part">
    <div class="row gy-4 justify-content-center">
        <div class="col-xxl-6 col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">{{__('Two Factor Authentication')}}</h4>
                </div>
                <div class="card-body">
                    <p>{{__('Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.')}}</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{__(' Enter the pin from Google Authenticator app')}}:<br/><br/>
                    <form class="form-horizontal" action="{{ route('user.2faVerify') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('one_time_password-code') ? ' has-error' : '' }}">
                            <label for="one_time_password" class="control-label">{{__('One Time Password')}}</label>
                            <input id="one_time_password" name="one_time_password" class="form-control col-md-12 mb-3"  type="text" required/>
                        </div>
                        <button class="btn cmn-btn" type="submit">{{__('Authenticate')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
