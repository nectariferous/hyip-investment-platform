@extends(template().'layout.master2')

@section('content2')
    <div class="dashboard-body-part">

        <div class="mobile-page-header">
            <h5 class="title">{{ __('Payment Informations') }}</h5>
            <a href="{{ route('user.deposit') }}" class="back-btn"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
        </div>
        
        <div class="row gy-4">
            <div class="col-xxl-6 col-xl-5">
                <div class="site-card">
                    <div class="card-header text-center">
                        <h5>{{ __('Payment Preview') }}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group text-capitalize">

                            @if(!(session('type') == 'deposit'))
                            <li class="list-group-item  d-flex justify-content-between">
                                <span class="fw-medium">{{ __('Plan Name') }}:</span>
                                <span>{{ $deposit->plan->plan_name }}</span>
                            </li>
                            @endif
                            <li class="list-group-item  d-flex justify-content-between">
                                <span class="fw-medium">{{ __('Gateway Name') }}:</span>
                                <span>{{ $deposit->gateway->gateway_name }}</span>
                            </li>
                            <li class="list-group-item  d-flex justify-content-between">
                                <span class="fw-medium">{{ __('Amount') }}:</span>
                                <span>{{ number_format($deposit->amount, 2) . ' ' . @$general->site_currency }}</span>
                            </li>

                            <li class="list-group-item  d-flex justify-content-between">
                                <span class="fw-medium">{{ __('Charge') }}:</span>
                                <span>{{ number_format($deposit->charge, 2) . ' ' . @$general->site_currency }}</span>
                            </li>

                            <li class="list-group-item  d-flex justify-content-between">
                                <span class="fw-medium">{{ __('Conversion Rate') }}:</span>
                                <span>{{ '1 ' . @$general->site_currency . ' = ' . number_format($deposit->rate, 2) . ' ' . @$general->site_currency }}</span>
                            </li>

                            <li class="list-group-item  d-flex justify-content-between">
                                <span class="fw-medium">{{ __('Total Payable Amount') }}:</span>
                                <span>{{ number_format($deposit->final_amount, 2) . ' ' . @$general->site_currency }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-7">
                <div class="site-card">
                    <div class="card-body">
                        <form role="form" action="" method="post" class="require-validation" data-cc-on-file="false"
                            data-stripe-publishable-key="{{ $gateway->gateway_parameters->stripe_client_id }}"
                            id="payment-form">
                            @csrf
                            <div class="row">
                                <div class='form-group col-md-12'>
                                    <div class='col-xs-12 required'>
                                        <label class='control-label mb-2'>{{ __('Name on Card') }}</label> <input
                                            class='form-control ' size='4' type='text'
                                            placeholder="{{ __('Enter name on card') }}">
                                    </div>
                                </div>

                                <div class='form-group col-md-12'>
                                    <div class='col-xs-12 required'>
                                        <label class='control-label mb-2 mt-2'>{{ __('Card Number') }}</label>
                                        <input autocomplete='off' class='form-control  card-number' size='20'
                                            type='text' placeholder="Enter card number">
                                    </div>
                                </div>

                                <div class='col-md-12'>
                                    <div class="row">
                                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                                            <label class='control-label mb-2 mt-2'>{{ __('CVC') }}</label>
                                            <input autocomplete='off' class='form-control  card-cvc' size='4'
                                                type='text' placeholder="{{ __('CVC') }}">
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                            <label
                                                class='control-label mb-2 mt-2'>{{ __('Expiration Month') }}</label>
                                            <input class='form-control  card-expiry-month' size='2'
                                                type='text' placeholder="{{ __('Expiration Month') }}">
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                            <label
                                                class='control-label mb-2 mt-2 '>{{ __('Expiration Year') }}</label>
                                            <input class='form-control  card-expiry-year' size='4'
                                                type='text' placeholder="{{ __('Expiration Year') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='form-group'>
                                <div class='col-md-12 error d-none'>
                                    <div class='alert-danger alert'>
                                        {{ __('Please correct the errors and try again.') }}</div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-xs-12 d-grid gap-2">
                                    <button class="btn main-btn" type="submit"><span>{{ __('Pay Now') }}</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://js.stripe.com/v2/"></script>

    <script>
        'use strict'
        $(function() {
            var $form = $(".require-validation");
            $('form.require-validation').bind('submit', function(e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }

            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }

        });
    </script>
@endpush
