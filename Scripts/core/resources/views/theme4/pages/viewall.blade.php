@extends(template() . 'layout.master2')


@section('content2')
<div class="dashboard-body-part">
  <div class="mobile-page-header">
      <h5 class="title">{{ __('View All') }}</h5>
      <a href="{{ route('user.dashboard') }}" class="back-btn"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
  </div>
  <!-- mobile screen card start -->
  <div class="col-12 d-sm-none">
    <div class="row gy-4 mobile-box-wrapper">
        <div class="col-3">
            <div class="mobile-box link-item">
                <a href="{{ route('user.investmentplan') }}" class="item-link"></a>
                <img src="{{ asset('asset/theme4/images/d-icon/1.png') }}" alt="icon">
                <h6 class="title">{{ __('Invest') }}</h6>
            </div>
        </div>
        <div class="col-3">
            <div class="mobile-box link-item">
                <a href="{{ route('user.deposit') }}" class="item-link"></a>
                <img src="{{ asset('asset/theme4/images/d-icon/2.png') }}" alt="icon">
                <h6 class="title">{{ __('Deposit') }}</h6>
            </div>
        </div>
        <div class="col-3">
            <div class="mobile-box link-item">
                <a href="{{ route('user.withdraw') }}" class="item-link"></a>
                <img src="{{ asset('asset/theme4/images/d-icon/3.png') }}" alt="icon">
                <h6 class="title">{{ __('Withdraw') }}</h6>
            </div>
        </div>
        <div class="col-3">
            <div class="mobile-box link-item">
                <a href="{{ route('user.transfer_money') }}" class="item-link"></a>
                <img src="{{ asset('asset/theme4/images/d-icon/4.png') }}" alt="icon">
                <h6 class="title">{{ __('Transfer') }}</h6>
            </div>
        </div>
        <div class="col-3">
            <div class="mobile-box link-item">
                <a href="{{ route('user.2fa') }}" class="item-link"></a>
                <img src="{{ asset('asset/theme4/images/d-icon/5.png') }}" alt="icon">
                <h6 class="title">{{ __('2FA') }}</h6>
            </div>
        </div>
        <div class="col-3">
            <div class="mobile-box link-item">
                <a href="{{ route('user.ticket.index') }}" class="item-link"></a>
                <img src="{{ asset('asset/theme4/images/d-icon/6.png') }}" alt="icon">
                <h6 class="title">{{ __('Support') }}</h6>
            </div>
        </div>
        <div class="col-3">
            <div class="mobile-box link-item">
                <a href="{{ route('user.profile') }}" class="item-link"></a>
                <img src="{{ asset('asset/theme4/images/d-icon/7.png') }}" alt="icon">
                <h6 class="title">{{ __('Settings') }}</h6>
            </div>
        </div>
    </div>

    <h5 class="mt-5 mb-4">{{ __('All Logs') }}</h5>
    <div class="row gy-4 mobile-box-wrapper">
        <div class="col-3">
            <div class="mobile-box link-item">
                <a href="{{ route('user.invest.log') }}" class="item-link"></a>
                <img src="{{ asset('asset/theme4/images/d-icon/1.png') }}" alt="icon">
                <h6 class="title">{{ __('Invest Log') }}</h6>
            </div>
        </div>
        <div class="col-3">
            <div class="mobile-box link-item">
                <a href="{{ route('user.deposit.log') }}" class="item-link"></a>
                <img src="{{ asset('asset/theme4/images/d-icon/2.png') }}" alt="icon">
                <h6 class="title">{{ __('Deposit Log') }}</h6>
            </div>
        </div>
        <div class="col-3">
            <div class="mobile-box link-item">
                <a href="{{ route('user.withdraw.all') }}" class="item-link"></a>
                <img src="{{ asset('asset/theme4/images/d-icon/3.png') }}" alt="icon">
                <h6 class="title">{{ __('Withdraw Log') }}</h6>
            </div>
        </div>
        <div class="col-3">
            <div class="mobile-box link-item">
                <a href="{{ route('user.transaction.log') }}" class="item-link"></a>
                <img src="{{ asset('asset/theme4/images/d-icon/4.png') }}" alt="icon">
                <h6 class="title">{{ __('Transaction Log') }}</h6>
            </div>
        </div>
        <div class="col-3">
            <div class="mobile-box link-item">
                <a href="{{ route('user.interest.log') }}" class="item-link"></a>
                <img src="{{ asset('asset/theme4/images/d-icon/5.png') }}" alt="icon">
                <h6 class="title">{{ __('Interest Log') }}</h6>
            </div>
        </div>
        <div class="col-3">
            <div class="mobile-box link-item">
                <a href="{{ route('user.commision') }}" class="item-link"></a>
                <img src="{{ asset('asset/theme4/images/d-icon/6.png') }}" alt="icon">
                <h6 class="title">{{ __('Referral Log') }}</h6>
            </div>
        </div>
    </div>
  </div>
  <!-- mobile screen card end -->
</div>
@endsection