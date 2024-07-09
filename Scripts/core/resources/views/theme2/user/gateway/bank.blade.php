@extends(template().'layout.master2')

@section('content2')
    <div class="dashboard-body-part">
        <div class="row gy-4">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{ __('Bank Payment Information') }}</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item text-light d-flex justify-content-between">
                                <span>{{ __('Bank Name') }}</span>
                                <span>{{ $gateway->gateway_parameters->name }}</span>
                            </li>

                            <li class="list-group-item text-light d-flex justify-content-between">
                                <span>{{ __('Account Number') }}</span>
                                <span>{{ $gateway->gateway_parameters->account_number }}</span>
                            </li>

                            <li class="list-group-item text-light d-flex justify-content-between">
                                <span>{{ __('Routing Number') }}</span>
                                <span>{{ $gateway->gateway_parameters->routing_number }}</span>
                            </li>

                            <li class="list-group-item text-light d-flex justify-content-between">
                                <span>{{ __('Branch Name') }}</span>
                                <span>{{ $gateway->gateway_parameters->branch_name }}</span>
                            </li>

                            <li class="list-group-item text-light d-flex justify-content-between">
                                <span>{{ __('Method Currency') }}</span>
                                <span>{{ $gateway->gateway_parameters->gateway_currency }}</span>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{ __('Payment Information') }}</h4>
                    </div>

                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item  text-light d-flex justify-content-between">
                                <span>{{ __('Gateway Name') }}:</span>

                                <span>{{ $deposit->gateway->gateway_name }}</span>

                            </li>
                            <li class="list-group-item  text-light d-flex justify-content-between">
                                <span>{{ __('Amount') }}:</span>
                                <span>{{ number_format($deposit->amount, 2) . ' ' . @$general->site_currency }}</span>
                            </li>

                            <li class="list-group-item  text-light d-flex justify-content-between">
                                <span>{{ __('Charge') }}:</span>
                                <span>{{ number_format($deposit->charge, 2) . ' ' . @$general->site_currency }}</span>
                            </li>

                            <li class="list-group-item  text-light d-flex justify-content-between">
                                <span>{{ __('Conversion Rate') }}:</span>
                                <span>{{ '1 ' . @$general->site_currency . ' = ' . number_format($deposit->rate, 2) }}</span>
                            </li>

                            <li class="list-group-item  text-light d-flex justify-content-between">
                                <span>{{ __('Total Payable Amount') }}:</span>
                                <span>{{ number_format($deposit->final_amount, 2) . ' ' . @$general->site_currency }}</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{ __('Payment Proof') }}</h4>
                    </div>

                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @foreach ($gateway->user_proof_param as $proof)
                                    @if ($proof['type'] == 'text')
                                        <div class="form-group col-md-12">
                                            <label for=""
                                                class="mb-2 mt-2">{{ __($proof['field_name']) }}</label>
                                            <input type="text"
                                                name="{{ strtolower(str_replace(' ', '_', $proof['field_name'])) }}"
                                                class="form-control bg-dark"
                                                {{ $proof['validation'] == 'required' ? 'required' : '' }}>
                                        </div>
                                    @endif
                                    @if ($proof['type'] == 'textarea')
                                        <div class="form-group col-md-12">
                                            <label for=""
                                                class="mb-2 mt-2">{{ __($proof['field_name']) }}</label>
                                            <textarea name="{{ strtolower(str_replace(' ', '_', $proof['field_name'])) }}" class="form-control bg-dark"
                                                {{ $proof['validation'] == 'required' ? 'required' : '' }}></textarea>
                                        </div>
                                    @endif

                                    @if ($proof['type'] == 'file')
                                        <div class="form-group col-md-12">
                                            <label for=""
                                                class="mb-2 mt-2">{{ __($proof['field_name']) }}</label>
                                            <input type="file"
                                                name="{{ strtolower(str_replace(' ', '_', $proof['field_name'])) }}"
                                                class="form-control bg-dark"
                                                {{ $proof['validation'] == 'required' ? 'required' : '' }}>
                                        </div>
                                    @endif
                                @endforeach


                                <div class="form-group">
                                    <button class="sp_theme_btn mt-4"
                                        type="submit">{{ __('Send Proof For Payment ') }}</button>

                                </div>


                            </div>



                        </form>



                    </div>

                </div>




            </div>
        </div>
    </div>
@endsection
