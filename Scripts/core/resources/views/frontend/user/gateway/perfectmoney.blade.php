@extends(template() . 'layout.master2')

@section('content2')
    <div class="dashboard-body-part">
        <div class="row gy-4">
            <div class="col-xxl-6 col-xl-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>{{ __('Payment Preview') }}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group text-capitalize">

                            @if (!(session('type') == 'deposit'))
                                <li class="list-group-item text-light  d-flex justify-content-between">
                                    <span>{{ __('Plan Name') }}:</span>

                                    <span>{{ $deposit->plan->plan_name }}</span>

                                </li>
                            @endif
                            <li class="list-group-item text-light  d-flex justify-content-between">
                                <span>{{ __('Gateway Name') }}:</span>

                                <span>{{ $deposit->gateway->gateway_name }}</span>

                            </li>
                            <li class="list-group-item text-light  d-flex justify-content-between">
                                <span>{{ __('Amount') }}:</span>
                                <span>{{ number_format($deposit->amount, 2) . ' ' . @$general->site_currency }}</span>
                            </li>

                            <li class="list-group-item text-light  d-flex justify-content-between">
                                <span>{{ __('Charge') }}:</span>
                                <span>{{ number_format($deposit->charge, 2) . ' ' . @$general->site_currency }}</span>
                            </li>


                            <li class="list-group-item text-light  d-flex justify-content-between">
                                <span>{{ __('Conversion Rate') }}:</span>
                                <span>{{ '1 ' . @$general->site_currency . ' = ' . number_format($deposit->rate, 2) . ' ' . @$deposit->gateway->gateway_parameters->gateway_currency }}</span>
                            </li>



                            <li class="list-group-item text-light  d-flex justify-content-between">
                                <span>{{ __('Total Payable Amount') }}:</span>
                                <span>{{ number_format($deposit->final_amount, 2) . ' ' . @$deposit->gateway->gateway_parameters->gateway_currency }}</span>
                            </li>



                        </ul>
                    </div>
                </div>
            </div>

           
            <div class="col-xxl-6 col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <form action="https://perfectmoney.is/api/step1.asp" method="POST">
                            <input type="hidden" name="PAYEE_ACCOUNT"
                                value="{{ $deposit->gateway->gateway_parameters->accountid }}">
                            <input type="hidden" name="PAYEE_NAME" value="{{ $general->sitename }}">
                            <input type="text" name="PAYMENT_AMOUNT" value="{{ round($deposit->final_amount, 2) }}"
                                placeholder="Amount" class="form-control" readonly>
                            <input type="hidden" name="PAYMENT_UNITS"
                                value="{{ $deposit->gateway->gateway_parameters->gateway_currency }}">
                            <input type="hidden" name="PAYMENT_URL" value="{{ route('user.perfectmoney.success') }}">
                            <input type="hidden" name="NOPAYMENT_URL" value="{{ route('user.perfectmoney.success') }}">

                            <input type="hidden" name="PAYMENT_ID" value="{{ $deposit->transaction_id }}">

                            <input type="hidden" name="STATUS_URL" value="{{ route('user.perfectmoney.success') }}">

                            <input type="hidden" name="PAYMENT_URL_METHOD" value="GET">

                            <input type="hidden" name="NOPAYMENT_URL_METHOD" value="GET">

                            <input type="hidden" name="SUGGESTED_MEMO" value="{{ auth()->user()->username }}">

                            <input type="submit" class="sp_theme_btn mt-4" value="Pay with Perfect Money">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
