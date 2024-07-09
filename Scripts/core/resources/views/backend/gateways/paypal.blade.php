@extends('backend.layout.master')

@section('content')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>


            <div class="row">

                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">

                                @csrf

                                <div class="row">

                                    <div class="form-group col-md-3 mb-3">
                                        <label class="col-form-label">{{ __('Paypal Image') }}</label>

                                        <div id="image-preview" class="image-preview"
                                            style="background-image:url({{ getFile('gateways', @$gateway->gateway_image) }});">
                                            <label for="image-upload"
                                                id="image-label">{{ __('Choose File') }}</label>
                                            <input type="file" name="paypal_image" id="image-upload" />
                                        </div>

                                    </div>

                                    <div class="col-md-9">

                                        <div class="row">


                                            <div class="form-group col-md-4">

                                                <label for="">{{ __('Gateway Currency') }}</label>
                                                <input type="text" name="gateway_currency"
                                                    class="form-control form_control site-currency"
                                                    value="{{ @$gateway->gateway_parameters->gateway_currency ?? old('gateway_currency') }}">
                                            </div>

                                            <div class="form-group col-md-4">

                                                <label for="">{{ __('Paypal Account Mode') }}</label>
                                                <select name="mode" id="" class="form-control selectric">
                                                    <option value="sandbox"
                                                        {{ @$gateway->gateway_parameters->mode == 'sandbox' ? 'selected' : '' }}>
                                                        {{ __('Sandbox') }}</option>
                                                    <option value="live"
                                                        {{ @$gateway->gateway_parameters->mode == 'live' ? 'selected' : '' }}>
                                                        {{ __('Live') }}</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>{{ __('Conversion Rate') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            {{ '1 ' . @$general->site_currency . ' = ' }}
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control currency" name="rate"
                                                        value="{{ number_format($gateway->rate, 4) ?? 0 }}">

                                                    <div class="input-group-append">
                                                        <div class="input-group-text append_currency">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="form-group col-md-12">

                                                <label for="">{{ __('Paypal Client id') }}</label>
                                                <input type="text" name="paypal_client_id" class="form-control"
                                                    value="{{ @$gateway->gateway_parameters->paypal_client_id ?? old('paypal_client_id') }}">
                                            </div>

                                            <div class="form-group col-md-12">

                                                <label for="">{{ __('Paypal Client Secret') }}</label>
                                                <input type="text" name="paypal_client_secret" class="form-control"
                                                    value="{{ @$gateway->gateway_parameters->paypal_client_secret ?? old('paypal_client_secret') }}">
                                            </div>

                                            <div class="form-group col-md-12">

                                                <label for="">{{ __('Allow as payment method') }}</label>

                                                <select name="status" id="" class="form-control selectric">

                                                    <option value="1" {{ @$gateway->status ? 'selected' : '' }}>
                                                        {{ __('Yes') }}
                                                    </option>
                                                    <option value="0" {{ @$gateway->status ? '' : 'selected' }}>
                                                        {{ __('No') }}</option>


                                                </select>

                                            </div>



                                        </div>



                                    </div>


                                    <div class="col-md-12">
                                        <button type="submit"
                                        class="btn btn-primary float-right">{{ __('Update Paypal Information') }}</button>
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>



@endsection


@push('script')

    <script>
        $(function() {
            'use strict'
            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "{{ __('Choose File') }}", // Default: Choose File
                label_selected: "{{ __('Update Image') }}", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });

            $('.site-currency').on('keyup', function() {
                $('.append_currency').text($(this).val())
            })

            $('.append_currency').text($('.site-currency').val())
        })
    </script>

@endpush
