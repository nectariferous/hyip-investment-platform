@extends(template().'layout.master2')

@section('content2')
  
    <section class="s-pt-100 s-pb-100">
        <div class="container">

            <div class="row">
                <div class="col-md-12 col-md-offset-3">
                    <div class="card bg-second">
                        <div class="card-header text-center">
                            <h5>{{ __('Payment Preview') }}</h5>
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


                                <li class="list-group-item  text-white">
                                    <form action="" method="POST">
                                        @csrf
                                        <input type="hidden" name="amount"
                                            value="{{ number_format($deposit->final_amount, 2) }}">
                                        <button type="submit" class="sp_theme_btn">{{ __('Pay With PayTm') }}</button>

                                    </form>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
