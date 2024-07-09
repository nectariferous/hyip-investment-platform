@extends('backend.layout.master')


@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ __($pageTitle) }}</h1>
        </div>

        <div class="row">


            <div class="col-md-12">
                <div class="card">

                    <div class="card-header bg-primary">

                        <h6 class="text-white">{{ __('KYC Form') }}</h6>

                        <button type="button" class="btn btn-success ml-auto payment"> <i class="fa fa-plus text-white"></i>
                            {{ __('Add KYC Requirements') }}</button>

                    </div>

                    <div class="card-body">

                        <form action="" method="post">
                            @csrf

                            <div class="row payment-instruction">

                                <div class="col-md-12 user-data">
                                    <div class="row">


                                        @if (@$general->kyc != null)
                                        @foreach ($general->kyc as $key => $param)
                                        <div class="col-md-12 user-data">
                                            <div class="form-group">
                                                <div class="input-group mb-md-0 mb-4">

                                                    <div class="col-md-3">
                                                        <label>{{ __('Label Name') }}</label>
                                                        <input name="kyc[{{ $key }}][label]" class="form-control form_control" type="text" value="{{ $param['label'] }}" required>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <label>{{ __('Field Name') }}</label>
                                                        <input name="kyc[{{ $key }}][field_name]" class="form-control form_control fieldName" type="text" value="{{ $param['field_name'] }}" required>
                                                    </div>
                                                    <div class="col-md-2 mt-md-0 mt-2">
                                                        <label>{{ __('Field Type') }}</label>
                                                        <select name="kyc[{{ $key }}][type]" class="form-control selectric">
                                                            <option value="text" {{ $param['type'] == 'text' ? 'selected' : '' }}>
                                                                {{ __('Input Text') }}
                                                            </option>
                                                            <option value="textarea" {{ $param['type'] == 'textarea' ? 'selected' : '' }}>
                                                                {{ __('Textarea') }}
                                                            </option>
                                                            <option value="file" {{ $param['type'] == 'file' ? 'selected' : '' }}>
                                                                {{ __('File upload') }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 mt-md-0 mt-2">
                                                        <label>{{ __('Field Validation') }}</label>
                                                        <select name="kyc[{{ $key }}][validation]" class="form-control selectric">
                                                            <option value="required" {{ $param['validation'] == 'required' ? 'selected' : '' }}>
                                                                {{ __('Required') }}
                                                            </option>
                                                            <option value="nullable" {{ $param['validation'] == 'nullable' ? 'selected' : '' }}>
                                                                {{ __('Optional') }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 text-right my-auto ">

                                                        <button class="btn btn-danger btn-lg remove w-100 mt-4" type="button">
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

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{ __('Update Kyc') }}</button>
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

        var i = "{{count($general->kyc ?? [])}}";

        $('.payment').on('click', function() {

            var html = `
                <div class="col-md-12 user-data">
                    <div class="form-group">
                        <div class="input-group mb-md-0 mb-4">

                            <div class="col-md-3">
                                <label>{{ __('Label Name') }}</label>
                                <input name="kyc[${i}][label]" class="form-control form_control" type="text" value="" required >
                            </div>

                            <div class="col-md-3">
                                <label>{{ __('Field Name') }}</label>
                                <input name="kyc[${i}][field_name]" class="form-control form_control fieldName" type="text" value="" required >
                            </div>
                            <div class="col-md-2 mt-md-0 mt-2">
                                <label>{{ __('Field Type') }}</label>
                                <select name="kyc[${i}][type]" class="form-control selectric">
                                    <option value="text" > {{ __('Input Text') }} </option>
                                    <option value="textarea" > {{ __('Textarea') }} </option>
                                    <option value="file"> {{ __('File upload') }} </option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-md-0 mt-2">
                                <label>{{ __('Field Validation') }}</label>
                                <select name="kyc[${i}][validation]"
                                        class="form-control selectric">
                                    <option value="required"> {{ __('Required') }} </option>
                                    <option value="nullable">  {{ __('Optional') }} </option>
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

        $(document).on('keyup', '.fieldName', function() {

            let data = $(this).val();

            $(this).val(data.replace(/[^a-zA-Z0-9 ]/g, ''));
        });

        $(document).on('click', '.remove', function() {
            $(this).closest('.user-data').remove();
        });

    })
</script>
@endpush