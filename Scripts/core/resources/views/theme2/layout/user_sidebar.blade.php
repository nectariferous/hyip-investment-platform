<div class="d-sidebar">
    <ul class="d-sidebar-menu">
      <li class="{{singleMenu('user.dashboard')}}">
        <a href="{{ route('user.dashboard') }}"><i class="fas fa-layer-group"></i> {{ __('Dashboard') }}</a>
      </li>

      <li class="has_submenu {{arrayMenu(['user.investmentplan','user.invest.log'])}}">
        <a href="#0"><i class="fas fa-funnel-dollar"></i> {{ __('Investment') }}</a>
        <ul class="submenu">
          <li class="{{singleMenu('user.investmentplan')}}">
            <a href="{{ route('user.investmentplan') }}"><i class="fas fa-minus"></i> {{ __('Investment Plans') }}</a>
          </li>
          <li class="{{singleMenu('user.invest.log')}}">
            <a href="{{ route('user.invest.log') }}"><i class="fas fa-minus"></i> {{ __('Invest Log') }}</a>
          </li>
        </ul>
      </li>

      <li class="has_submenu {{arrayMenu(['user.deposit','user.deposit.log'])}}">
        <a href="#0"><i class="fas fa-coins"></i> {{ __('Deposit') }}</a>
        <ul class="submenu">
          <li class="{{singleMenu('user.deposit')}}">
            <a href="{{ route('user.deposit') }}"><i class="fas fa-minus"></i> {{ __('Deposit') }}</a>
          </li>
          <li class="{{singleMenu('user.deposit.log')}}">
            <a href="{{ route('user.deposit.log') }}"><i class="fas fa-minus"></i> {{ __('Deposit Log') }}</a>
          </li>
        </ul>
      </li>

      <li class="has_submenu {{arrayMenu(['user.withdraw','user.withdraw.*'])}}">
        <a href="#0"><i class="fas fa-hand-holding-usd"></i> {{ __('Withdraw') }}</a>
        <ul class="submenu">
          <li class="{{singleMenu('user.withdraw')}}">
            <a href="{{ route('user.withdraw') }}"><i class="fas fa-minus"></i> {{ __('Withdraw') }}</a>
          </li>
          <li class="{{singleMenu('user.withdraw.*')}}">
            <a href="{{ route('user.withdraw.all') }}"><i class="fas fa-minus"></i> {{ __('Withdraw Log') }}</a>
          </li>
        </ul>
      </li>

      <li class="{{singleMenu('user.transfer_money')}}">
        <a href="{{ route('user.transfer_money') }}"><i class="fas fa-exchange-alt"></i> {{ __('Transfer Money') }}</a>
      </li>

       <li class="{{activeMenu(route('user.money.log'))}}">
            <a href="{{ route('user.money.log') }}">
                <i class="las la-exchange-alt me-3"></i> 
                {{ __('Money Transfer Log') }}
            </a>
        </li>

        
      <li class="{{singleMenu('user.interest.log')}}">
        <a href="{{ route('user.interest.log') }}"><i class="far fa-file-alt"></i> {{ __('Interest Log') }}</a>
      </li>
      <li class="{{singleMenu('user.transaction.log')}}">
        <a href="{{ route('user.transaction.log') }}"><i class="fas fa-file-invoice-dollar"></i> {{ __('Transaction Log') }}</a>
      </li>

      <li class="{{singleMenu('user.commision')}}">
        <a href="{{ route('user.commision') }}"><i class="fas fa-file-invoice-dollar"></i> {{ __('Refferal Log') }}</a>
      </li>


      <li class="{{singleMenu('user.2fa')}}">
        <a href="{{ route('user.2fa') }}"><i class="fas fa-user-shield"></i> {{ __('2FA') }}</a>
      </li>
      <li class="{{singleMenu('user.ticket.index')}}">
        <a href="{{ route('user.ticket.index') }}"><i class="fas fa-headset"></i> {{ __('Support') }}</a>
      </li>
      <li>
        <a href="{{ route('user.logout') }}"><i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}</a>
      </li>
    </ul>
    <div class="d-plan-notice mt-4 mx-3">
        <p class="mb-0">{{ __('Your Current Plan') }}
            -{{ isset($currentPlan->plan->plan_name) ? $currentPlan->plan->plan_name : 'N/A' }}</p>
        <a href="{{ route('user.investmentplan') }}">{{ __('Update Plan') }} <i
                class="fas fa-arrow-up"></i></a>
    </div>
</div>
