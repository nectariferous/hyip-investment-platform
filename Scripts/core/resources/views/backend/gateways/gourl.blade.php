@extends('backend.layout.master')

@section('content')
    <div class="main-content">
        <section class="section">


            <div class="row">

                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body d-flex flex-wrap">
                            <h5>{{ __($pageTitle) }}</h5>
                            <div class="input-group w-25 ml-auto">
                                <select class="custom-select" id="currency">
                                    @foreach ($currency as $key => $cur)
                                        <option value="{{ $cur['currency'] }}" data-currency="{{ $cur['currency'] }}">
                                            {{ Str::ucfirst($key) }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="addNew"> <i
                                            class="fa fa-plus"></i>
                                        {{ __('Add New') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">

                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf

                                @foreach ($gateways as $gateway)
                                    <div class="row" id="appear">

                                        <div class="form-group col-md-3 mb-3">
                                            <label class="col-form-label">{{ __('Gourl Image') }}</label>

                                            <div id="image-preview-{{$gateway->gateway_parameters->gateway_currency}}" class="image-preview"
                                                style="background-image:url({{ getFile('gateways', @$gateway->gateway_image) }});">
                                                <label for="image-upload-{{$gateway->gateway_parameters->gateway_currency}}"
                                                    id="image-label-{{$gateway->gateway_parameters->gateway_currency}}">{{ __('Choose File') }}</label>
                                                <input type="file" name="gateway_parameter[{{$gateway->gateway_parameters->gateway_currency}}][gourl_image]"
                                                    id="image-upload-{{$gateway->gateway_parameters->gateway_currency}}" data-id="{{$gateway->gateway_parameters->gateway_currency}}" class="imageUploader" />
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">

                                                <div class="form-group col-md-12">

                                                    <label for="">{{ __('Public Key') }}</label>
                                                    <input type="text" name="gateway_parameter[{{$gateway->gateway_parameters->gateway_currency}}][public_key]"
                                                        class="form-control" value="{{$gateway->gateway_parameters->public_key}}">
                                                </div>

                                                <div class="form-group col-md-12">

                                                    <label for="">{{ __('Private Key') }}</label>
                                                    <input type="text" name="gateway_parameter[{{$gateway->gateway_parameters->gateway_currency}}][private_key]"
                                                        class="form-control" value="{{$gateway->gateway_parameters->private_key}}">
                                                </div>


                                                <div class="form-group col-md-3">
                                                    <label for="">{{ __('Gateway Currency') }}</label>

                                                    <input type="text" name="gateway_parameter[{{$gateway->gateway_parameters->gateway_currency}}][gateway_currency]"
                                                        class="form-control site-currency"
                                                        value="{{$gateway->gateway_parameters->gateway_currency}}" readonly>
                                                </div>

                                                <div class="form-group col-md-5 col-12">
                                                    <label>{{ __('Conversion Rate') }}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                {{ '1 ' . @$general->site_currency . ' = ' }}
                                                            </div>
                                                        </div>
                                                        <input type="text" class="form-control form_control currency"
                                                            name="gateway_parameter[{{$gateway->gateway_parameters->gateway_currency}}][rate]" value="{{$gateway->rate}}">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text append_currency">
                                                                {{$gateway->gateway_parameters->gateway_currency}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4 col-12">
                                                    <label for="">{{ __('Allow as payment method') }}</label>
                                                    <select name="gateway_parameter[{{$gateway->gateway_parameters->gateway_currency}}][status]" id=""
                                                        class="form-control selectric">
                                                        <option value="1" {{ @$gateway->status ? 'selected' : '' }}>
                                                            {{ __('Yes') }}
                                                        </option>
                                                        <option value="0" {{ @$gateway->status ? '' : 'selected' }}>
                                                            {{ __('No') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                @endforeach




                                <div class="col-md-12">
                                    <button type="submit"
                                        class="btn btn-primary float-right">{{ __('Update GoUrl.io Information') }}</button>
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


            $(document).on('change', '.imageUploader', function() {
                showImagePreview(this, "#image-preview-" + $(this).data('id'));
            })

            function showImagePreview(input, id) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $(id).css('background-image', "url(" + e.target.result + ")");
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }



            let currencyAdded = @json($gateways->pluck('gateway_parameters.gateway_currency')->toArray());

            $('#addNew').on('click', function() {
                let currency = $('#currency option:selected').val();

                if (currencyAdded.includes(currency)) {
                    iziToast.error({
                        message: "Already Added This Currency",
                        position: 'topRight'
                    });

                    return
                }


                let html = `
                

                <div class="row removeEl" >

                    <div class="col-md-12 text-right">
                        <button class="btn btn-danger remove" data-currncy="${currency}"><i class="fa fa-times"></i></button>
                    </div>

                    <div class="form-group col-md-3 mb-3">
                        <label class="col-form-label">{{ __('Gourl Image') }}</label>

                        <div id="image-preview-${currency}" class="image-preview">
                            <label for="image-upload-${currency}" id="image-label-${currency}">{{ __('Choose File') }}</label>
                            <input type="file" name="gateway_parameter[${currency}][gourl_image]" id="image-upload-${currency}" data-id="${currency}" class="imageUploader"/>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="row">
                            



                            <div class="form-group col-md-12">

                                <label for="">{{ __('Public Key') }}</label>
                                <input type="text" name="gateway_parameter[${currency}][public_key]" class="form-control">
                            </div>

                            <div class="form-group col-md-12">

                                <label for="">{{ __('Private Key') }}</label>
                                <input type="text" name="gateway_parameter[${currency}][private_key]" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">{{ __('Gateway Currency') }}</label>

                                <input type="text" name="gateway_parameter[${currency}][gateway_currency]"
                                    class="form-control site-currency"
                                    value="${currency}" readonly>
                            </div>

                            <div class="form-group col-md-5 col-12">
                                <label>{{ __('Conversion Rate') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            {{ '1 ' . @$general->site_currency . ' = ' }}
                                        </div>
                                    </div>
                                    <input type="text" class="form-control form_control currency"
                                        name="gateway_parameter[${currency}][rate]" >
                                    <div class="input-group-append">
                                        <div class="input-group-text append_currency">
                                            ${currency}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-4 col-12">
                                <label for="">{{ __('Allow as payment method') }}</label>
                                <select name="gateway_parameter[${currency}][status]" id="" class="form-control selectric">
                                    <option value="1" {{ @$gateway->status ? 'selected' : '' }}>
                                        {{ __('Yes') }}
                                    </option>
                                    <option value="0" {{ @$gateway->status ? '' : 'selected' }}>
                                        {{ __('No') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>


                   
                </div>
                
                `;


                currencyAdded.push(currency);
                $('#appear').after(html)
            })



            $(document).on('click', '.remove', function(e) {
                e.preventDefault();


                currencyAdded.splice(currencyAdded.indexOf($(this).data('currency')), 1);


                $(this).parents().find('.removeEl').remove()
            })



            $(document).on('keyup', '.site-currency', function() {
                $('.append_currency').text($(this).val())
            })

            
        })
    </script>
@endpush
