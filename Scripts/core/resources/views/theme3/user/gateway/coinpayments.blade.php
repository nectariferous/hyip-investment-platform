@extends(template().'layout.master2')

@section('content2')
    <div class="dashboard-body-part">
        
        <div class="mobile-page-header">
            <h5 class="title">{{ __('Payment Informations') }}</h5>
            <a href="{{ route('user.deposit') }}" class="back-btn"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="site-card">
                    <div class="card-header text-center">
                        <h5 class="mb-0">{{ __('Payment Preview') }}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @if(!(session('type') == 'deposit'))
                            <li class="list-group-item  d-flex justify-content-between">
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
                                <span>{{ '1 ' . @$general->site_currency . ' = ' . number_format($deposit->rate, 2) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-medium">{{ __('Total Payable Amount') }}:</span>
                                <span>{{ number_format($deposit->final_amount, 2) }}</span>
                            </li>

                        </ul>

                        <div class="mt-4 text-end">
                            <form action="https://www.coinpayments.net/index.php" method="post">
                                <input type="hidden" name="cmd" value="_pay_simple">
                                <input type="hidden" name="reset" value="1">
                                <input type="hidden" name="merchant" value="{{$deposit->gateway->gateway_parameters->merchant_id}}">
                                <input type="hidden" name="item_name" value="payment">
                                <input type="hidden" name="currency" value="{{$general->site_currency}}">
                                <input type="hidden" name="amountf" value="{{$deposit->final_amount}}">
                                <input type="hidden" name="want_shipping" value="0">
                                <input type="hidden" name="success_url" value="{{route('user.coin.pay')}}">
                                <input type="hidden" name="cancel_url" value="test">
                                <input type="hidden" name="ipn_url" value="{{route('user.coin.pay')}}">
                                <input type="image" src="https://www.coinpayments.net/images/pub/buynow-grey.png" alt="Buy Now with CoinPayments.net">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
