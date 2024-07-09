@extends(template().'layout.master2')


@section('content2')
    <div class="dashboard-body-part">

        <div class="mobile-page-header">
            <h5 class="title">{{ __('Password') }}</h5>
            <a href="{{ route('user.dashboard') }}" class="back-btn"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
        </div>

        <div class="row justify-content-center">
            <div class="col-xxl-6 xol-xl-8">
                <div class="site-card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('Change Password') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.update.password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1"
                                    class="mt-2 mb-2">{{ __('Old Password') }}</label>
                                <input type="password" class="form-control" name="oldpassword"
                                    placeholder="{{ __('Enter Old Password') }}">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1"
                                    class="mt-2 mb-2">{{ __('New Password') }}</label>
                                <input type="password" class="form-control" name="password"
                                    placeholder="{{ __('Enter New Password') }}">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1"
                                    class="mt-2 mb-2">{{ __('Confirm Password') }}</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    placeholder="{{ __('Confirm Password') }}">
                            </div>
                            <div class="row mt-4">
                                <div class="col-xs-12 d-grid gap-2">
                                    <button class="btn sp_btn_success w-100" type="submit">{{ __('Update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
