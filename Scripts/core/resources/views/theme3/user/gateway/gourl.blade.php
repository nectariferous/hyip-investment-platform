@extends(template().'layout.master2')

@section('content2')
    <div class="dashboard-body-part">

        <div class="mobile-page-header">
            <h5 class="title">{{ __('Payment Informations') }}</h5>
            <a href="{{ route('user.deposit') }}" class="back-btn"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="site-card">
                    <div class="card-header text-center">
                        <h5>{{ __('Payment Preview') }}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @if(!(session('type') == 'deposit'))
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-medium">{{ __('Plan Name') }}:</span>
                                <span>{{ $deposit->plan->plan_name }}</span>
                            </li>
                            @endif
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-medium">{{ __('Gateway Name') }}:</span>
                                <span>{{ $deposit->gateway->gateway_name }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-medium">{{ __('Amount') }}:</span>
                                <span>{{ number_format($deposit->amount, 2) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-medium">{{ __('Charge') }}:</span>
                                <span>{{ number_format($deposit->charge, 2) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-medium">{{ __('Conversion Rate') }}:</span>
                                <span>{{ '1 ' . @$general->site_currency . ' = ' .$deposit->rate.' '. $gateway->gateway_parameters->gateway_currency }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-medium">{{ __('Total Payable Amount') }}:</span>
                                <span>{{ $deposit->final_amount * $deposit->rate .' '. $gateway->gateway_parameters->gateway_currency }}</span>
                            </li>
                        </ul>
                        <div class="mt-4 text-end">
                            <form action="" method="post">
                                @csrf
                                <button type="submit" class="btn main-btn w-100">{{__('Pay with '. $deposit->gateway->gateway_name)}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection