@extends(template().'layout.master2')

@section('content2')
    <div class="dashboard-body-part">
        <div class="card">
            <div class="card-header text-center">
                <h4 class="mb-0">{{ __('Payment Preview') }}</h4>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @if(!(session('type') == 'deposit'))
                    <li class="list-group-item text-light  d-flex justify-content-between">
                        <span>{{ __('Plan Name') }}:</span>

                        <span>{{ $deposit->plan->plan_name }}</span>

                    </li>
                    @endif
                    <li class="list-group-item   text-white d-flex justify-content-between">
                        <span>{{ __('Gateway Name') }}:</span>

                        <span>{{ $deposit->gateway->gateway_name }}</span>

                    </li>
                    <li class="list-group-item   text-white d-flex justify-content-between">
                        <span>{{ __('Amount') }}:</span>
                        <span>{{ number_format($deposit->amount, 2) }}</span>
                    </li>

                    <li class="list-group-item  text-white  d-flex justify-content-between">
                        <span>{{ __('Charge') }}:</span>
                        <span>{{ number_format($deposit->charge, 2) }}</span>
                    </li>


                    <li class="list-group-item  text-white  d-flex justify-content-between">
                        <span>{{ __('Conversion Rate') }}:</span>
                        <span>{{ '1 ' . @$general->site_currency . ' = ' . number_format($deposit->rate, 2) }}</span>
                    </li>



                    <li class="list-group-item   text-white d-flex justify-content-between">
                        <span>{{ __('Total Payable Amount') }}:</span>
                        <span>{{ number_format($deposit->final_amount, 2) }}</span>
                    </li>
                </ul>

                <div class="text-end mt-3">
                    <form action="" method="POST">
                        @csrf
                        <input type="hidden" name="amount"
                            value="{{ number_format($deposit->final_amount, 2) }}">
                        <button type="submit" class="sp_theme_btn ">{{ __('Pay With Mollie') }}</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
