@extends('backend.layout.master')

@section('content')

<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>{{__($pageTitle)}}</h1>
      </div>

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.gateway.update', $gateway->id)}}" method="post" enctype="multipart/form-data">

                        @csrf

                        @method('PUT')

                        <div class="row">

                            <div class="form-group col-md-3">
                                <label class="col-form-label">{{__('Gateway Image')}}</label>

                                <div id="image-preview" class="image-preview"
                                    style="background-image:url({{ getFile('gateways' ,$gateway->gateway_image) }});">
                                    <label for="image-upload" id="image-label">{{__('Choose File')}}</label>
                                    <input type="file" name="image" id="image-upload" />
                                </div>

                            </div>

                            <div class="col-md-9">

                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <label class="col-form-label">{{__('QR Code')}}</label>
        
                                        <div id="image-preview-1" class="image-preview"
                                            style="background-image:url({{ getFile('gateways' ,$gateway->gateway_parameters->qr_code) }});">
                                            <label for="image-upload-1" id="image-label-1">{{__('Choose File')}}</label>
                                            <input type="file" name="qr_code" id="image-upload-1" />
                                        </div>
        
                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="">{{__('Name')}}</label>
                                        <input type="text" name="name"  class="form-control" value="{{str_replace('_btc','',$gateway->gateway_name)}}">

                                    </div>

                                   

                                    <div class="form-group col-md-6">

                                        <label for="">{{__('Gateway Currency')}}</label>
                                        <input type="text" name="gateway_currency" class="form-control site-currency"
                                            
                                            value="{{ @$gateway->gateway_parameters->gateway_currency ?? '' }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>{{__('Conversion Rate')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    {{"1 ".@$general->site_currency.' = '}}
                                                </div>
                                            </div>
                                            <input type="text" class="form-control currency" name="rate" value="{{$gateway->rate}}">

                                            <div class="input-group-append">
                                                <div class="input-group-text append_currency">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    
                                    <div class="form-group col-md-4">
                                        <label>{{__('Charge')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    {{@$general->site_currency}}
                                                </div>
                                            </div>
                                            <input type="text" class="form-control currency" name="charge"  value="{{$gateway->charge}}">

                                            
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="">{{__('Allow as payment method')}}</label>

                                        <select name="status" id="" class="form-control selectric">

                                            <option value="1" {{ @$gateway->status ? 'selected' : '' }}>{{__('Yes')}}
                                            </option>
                                            <option value="0" {{ @$gateway->status ? '' : 'selected' }}>{{__('No')}}
                                            </option>


                                        </select>

                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="">{{__('Payment Instruction')}}</label>
                                        <textarea name="instruction" id="" cols="30" rows="10" class="form-control summernote">
                                            {{clean($gateway->gateway_parameters->instruction)}}
                                        </textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="card">

                                    <div class="card-header bg-primary">

                                        <h6 class="text-white">{{__('User Proof Requirements')}}</h6>

                                        <button type="button" class="btn btn-success ml-auto payment"> <i
                                                class="fa fa-plus text-white"></i>
                                            {{__('Add Payment Requirements')}}</button>

                                    </div>

                                    <div class="card-body">

                                        <div class="row payment-instruction">

                                            <div class="col-md-12 user-data">
                                                <div class="row">


                                                    @if (@$gateway->user_proof_param != null)


                                                        @foreach ($gateway->user_proof_param as $key => $param)
                
                                                            <div class="col-md-12 user-data">
                                                                <div class="form-group">
                                                                    <div class="input-group mb-md-0 mb-4">
                                                                        <div class="col-md-4">
                                                                            <label>{{__('Field Name')}}</label>
                                                                            <input
                                                                                name="user_proof_param[{{ $key }}][field_name]"
                                                                                class="form-control form_control"
                                                                                type="text"
                                                                                value="{{ $param['field_name'] }}"
                                                                                required >
                                                                        </div>
                                                                        <div class="col-md-3 mt-md-0 mt-2">
                                                                            <label>{{__('Field Type')}}</label>
                                                                            <select
                                                                                name="user_proof_param[{{ $key }}][type]"
                                                                                class="form-control selectric">
                                                                                <option value="text"
                                                                                    {{ $param['type'] == 'text' ? 'selected' : '' }}>
                                                                                    {{__('Input Text')}}
                                                                                </option>
                                                                                <option value="textarea"
                                                                                    {{ $param['type'] == 'textarea' ? 'selected' : '' }}>
                                                                                    {{__('Textarea')}}
                                                                                </option>
                                                                                <option value="file"
                                                                                    {{ $param['type'] == 'file' ? 'selected' : '' }}>
                                                                                    {{__('File upload')}}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-3 mt-md-0 mt-2">
                                                                            <label>{{__('Field Validation')}}</label>
                                                                            <select
                                                                                name="user_proof_param[{{ $key }}][validation]"
                                                                                class="form-control selectric">
                                                                                <option value="required"
                                                                                    {{ $param['validation'] == 'required' ? 'selected' : '' }}>
                                                                                    {{__('Required')}}
                                                                                </option>
                                                                                <option value="nullable"
                                                                                    {{ $param['validation'] == 'nullable' ? 'selected' : '' }}>
                                                                                    {{__('Optional')}}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div
                                                                            class="col-md-2 text-right my-auto ">

                                                                            <button
                                                                                class="btn btn-danger btn-lg remove w-100 mt-4"
                                                                                type="button">
                                                                                <i class="fa fa-times"></i>
                                                                            </button>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach


                                                    @endif
                                                </div>

                                            </div>


                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary w-100">
                                {{__('Update Gateway')}}</button>
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

            var i = {{count($gateway->user_proof_param ?? [])}};

            $('.payment').on('click', function() {

                var html = `
                <div class="col-md-12 user-data">
                    <div class="form-group">
                        <div class="input-group mb-md-0 mb-4">
                            <div class="col-md-4">
                                <label>{{__('Field Name')}}</label>
                                <input name="user_proof_param[${i}][field_name]" class="form-control form_control" type="text" value="" required >
                            </div>
                            <div class="col-md-3 mt-md-0 mt-2">
                                <label>{{__('Field Type')}}</label>
                                <select name="user_proof_param[${i}][type]" class="form-control selectric">
                                    <option value="text" > {{__('Input Text')}} </option>
                                    <option value="textarea" > {{__('Textarea')}} </option>
                                    <option value="file"> {{__('File upload')}} </option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-md-0 mt-2">
                                <label>{{__('Field Validation')}}</label>
                                <select name="user_proof_param[${i}][validation]"
                                        class="form-control selectric">
                                    <option value="required"> {{__('Required')}} </option>
                                    <option value="nullable">  {{__('Optional')}} </option>
                                </select>
                            </div>
                            <div class="col-md-2 text-right my-auto">
                              
                                    <button class="btn btn-danger btn-lg remove w-100 mt-4" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                
                            </div>
                        </div>
                    </div>
                </div>`;
                $('.payment-instruction').append(html);

                i++;

            })

            $(document).on('click', '.remove', function() {
                $(this).closest('.user-data').remove();
            });

            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "{{__('Choose File')}}", // Default: Choose File
                label_selected: "{{__('Update Image')}}", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });


            $.uploadPreview({
                input_field: "#image-upload-1", // Default: .image-upload
                preview_box: "#image-preview-1", // Default: .image-preview
                label_field: "#image-label-1", // Default: .image-label
                label_default: "{{__('Choose File')}}", // Default: Choose File
                label_selected: "{{__('Update Image')}}", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });

             $('.site-currency').on('keyup',function(){
            $('.append_currency').text($(this).val())
        })

        $('.append_currency').text($('.site-currency').val())
        })
    </script>

@endpush
