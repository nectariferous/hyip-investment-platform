@extends('backend.layout.master')

@section('content')
    <link rel="stylesheet"
        href="{{ asset('asset/admin/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css') }}" />
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>


            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <form action="" method="post" enctype="multipart/form-data">

                                @csrf

                                <div class="row">


                                    <div class="form-group col-md-2">
                                        <label for="sitename">{{ __('Site Name') }}</label>
                                        <input type="text" name="sitename" placeholder="@lang('site name')"
                                            class="form-control form_control" value="{{ @$general->sitename }}">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="site_currency">{{ __('Site Currency') }}</label>
                                        <input type="text" name="site_currency" class="form-control"
                                            placeholder="Enter Site Currency" value="{{ @$general->site_currency ?? '' }}">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="primary_color">{{ __('Primary Color') }}</label>
                                        <div id="cp1" class="input-group" title="Using input value">
                                            <span class="input-group-append">
                                                <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                            </span>
                                            <input type="text" name="primary_color" class="form-control input-lg" data-color="hsl(56, 93%, 63%)"
                                                value="{{ @$general->primary_color }}" />
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="signup_bonus">{{ __('Sign Up Bonus') }}</label>
                                        <input type="text" name="signup_bonus" placeholder="@lang('Sign Up Bonus')"
                                            class="form-control form_control"
                                            value="{{ number_format(@$general->signup_bonus, 2) }}">
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label for="timezone">{{ __('Timezone') }}</label>
                                        <select name="timezone" id="" class="form-control">
                                            @foreach ($timezone as $zone)
                                                <option value="{{$zone}}" {{env('APP_TIMEZONE') == $zone ? 'selected' : ''}}>{{$zone}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group col-md-6">

                                        <label for="">{{ __('Nexmo Key') }} <a href="https://www.nexmo.com/"
                                                target="_blank">{{ __('API Link') }}</a></label>
                                        <input type="text" name="sms_username" class="form-control"
                                            placeholder="Sms API KEY" value="{{ env('NEXMO_KEY') }}">

                                    </div>


                                    <div class="form-group col-md-6">

                                        <label for="">{{ __('Nexmo Secret') }}</label>
                                        <input type="text" name="sms_password" class="form-control"
                                            placeholder="Sms API Secret" value="{{ env('NEXMO_SECRET') }}">

                                    </div>


                                    <div class="form-group col-md-3">
                                        <label for="">{{ __('Transfer Limit Per Day') }}</label>
                                        <input type="number" name="trans_limit" class="form-control" value="{{ $general->trans_limit }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="">{{ __('Transfer Charge') }}</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <input type="number" name="trans_charge" class="form-control" value="{{ $general->trans_charge }}">
                                            </div>
                                            <select class="form-control" id="inputGroupSelect01" name="trans_type">
                                                <option value="fixed" {{ $general->trans_type === 'fixed' ? 'selected' : '' }}>{{ __('Fixed') }}</option>
                                                <option value="percent" {{ $general->trans_type === 'fixed' ? '' : 'selected' }}>{{ __('Percent') }}</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label for="">{{ __('Transfer Min Amount') }}</label>
                                        <input type="number" name="min_amount" class="form-control" value="{{ $general->min_amount }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="">{{ __('Transfer Max Amount') }}</label>
                                        <input type="number" name="max_amount" class="form-control" value="{{ $general->max_amount }}">
                                    </div>



                                    <div class="form-group col-md-4">
                                        <label for="sitename">{{ __('Copyright Text') }}</label>
                                        <input type="text" name="copyright" placeholder="@lang('Copyright Text')"
                                            class="form-control form_control" value="{{ @$general->copyright }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label>{{ __('Withdraw Limit') }}</label>
                                        <div class="input-group">
                                            <input type="text" name="withdraw_limit" placeholder="@lang('Withdraw Limit')"
                                                class="form-control form_control"
                                                value="{{ @$general->withdraw_limit }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text"
                                                    id="basic-addon2">{{ __('Times per day') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="sitename">{{ __('Map Link') }}</label>
                                        <input type="text" name="map_link" placeholder="@lang('Map Link')"
                                            class="form-control form_control" value="{{ @$general->map_link }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="" class="w-100">{{ __('Email Verification On') }} </label>
                                        <div class="custom-switch custom-switch-label-onoff">
                                            <input class="custom-switch-input" id="ev" type="checkbox"
                                                name="is_email_verification_on"
                                                {{ @$general->is_email_verification_on ? 'checked' : '' }}>
                                            <label class="custom-switch-btn" for="ev"></label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="" class="w-100">{{ __('SMS Verification On') }} </label>
                                        <div class="custom-switch custom-switch-label-onoff">
                                            <input class="custom-switch-input" id="sv" type="checkbox"
                                                name="is_sms_verification_on"
                                                {{ @$general->is_sms_verification_on ? 'checked' : '' }}>
                                            <label class="custom-switch-btn" for="sv"></label>
                                        </div>
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label for="" class="w-100">{{ __('User Registration') }} </label>
                                        <div class="custom-switch custom-switch-label-onoff">
                                            <input class="custom-switch-input" id="ug_r" type="checkbox"
                                                name="user_reg" {{ @$general->user_reg ? 'checked' : '' }}>
                                            <label class="custom-switch-btn" for="ug_r"></label>
                                        </div>
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label for="" class="w-100">{{ __('User KYC') }} </label>
                                        <div class="custom-switch custom-switch-label-onoff">
                                            <input class="custom-switch-input" id="ug_kyc" type="checkbox"
                                                name="user_kyc" {{ @$general->user_kyc ? 'checked' : '' }}>
                                            <label class="custom-switch-btn" for="ug_kyc"></label>
                                        </div>
                                    </div>




                                    <div class="form-group col-md-4 mb-3">
                                        <label class="col-form-label">{{ __('logo') }}</label>

                                        <div id="image-preview" class="image-preview"
                                            style="background-image:url({{ getFile('logo', @$general->logo) }});">
                                            <label for="image-upload" id="image-label">{{ __('Choose File') }}</label>
                                            <input type="file" name="logo" id="image-upload" />
                                        </div>

                                    </div>

                                    <div class="form-group col-md-4 mb-3">
                                        <label class="col-form-label">{{ __('Black logo') }}</label>

                                        <div id="image-preview-whitelogo" class="image-preview"
                                            style="background-image:url({{ getFile('logo', @$general->whitelogo) }});">
                                            <label for="image-upload-whitelogo" id="image-label-whitelogo">{{ __('Choose File') }}</label>
                                            <input type="file" name="whitelogo" id="image-upload-whitelogo" />
                                        </div>

                                    </div>

                                    <div class="form-group col-md-4 mb-3">
                                        <label class="col-form-label">{{ __('Icon') }}</label>
                                        <div id="image-preview-icon" class="image-preview"
                                            style="background-image:url({{ getFile('icon', @$general->favicon) }});">
                                            <label for="image-upload-icon"
                                                id="image-label-icon">{{ __('Choose File') }}</label>
                                            <input type="file" name="icon" id="image-upload-icon" />
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4 mb-3">
                                        <label class="col-form-label">{{ __('Login Image') }}</label>
                                        <div id="image-preview-login" class="image-preview"
                                            style="background-image:url({{ getFile('login', @$general->login_image) }});">
                                            <label for="image-upload-login"
                                                id="image-label-login">{{ __('Choose File') }}</label>
                                            <input type="file" name="login_image" id="image-upload-login" />
                                        </div>
                                    </div>


                                    <div class="form-group col-md-4 mb-3">
                                        <label class="col-form-label">{{ __('Frontend Login Image') }}</label>
                                        <div id="image-preview-login_image" class="image-preview"
                                            style="background-image:url({{ getFile('frontendlogin', @$general->frontend_login_image) }});">
                                            <label for="image-upload-login_image"
                                                id="image-label-login_image">{{ __('Choose File') }}</label>
                                            <input type="file" name="frontend_login_image"
                                                id="image-upload-login_image" />
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4 mb-3">
                                        <label class="col-form-label">{{ __('Frontend Breadcrumbs Image') }}</label>
                                        <div id="image-preview-breadcrumbs" class="image-preview"
                                            style="background-image:url({{ getFile('breadcrumbs', @$general->breadcrumbs) }});">
                                            <label for="image-upload-breadcrumbs"
                                                id="image-label-breadcrumbs">{{ __('Choose File') }}</label>
                                            <input type="file" name="breadcrumbs" id="image-upload-breadcrumbs" />
                                        </div>
                                    </div>


                                    <div class="form-group col-md-4 mb-3">
                                        <label class="col-form-label">{{ __('Frontend Main Background Image') }}</label>
                                        <div id="image-preview-main" class="image-preview"
                                            style="background-image:url({{ getFile('main', @$general->frontend_main_background_image) }});">
                                            <label for="image-upload-main"
                                                id="image-label-main">{{ __('Choose File') }}</label>
                                            <input type="file" name="main" id="image-upload-main" />
                                        </div>
                                    </div>




                                    <div class="form-group col-md-12">

                                        <button type="submit"
                                            class="btn btn-primary float-right">{{ __('Update General Setting') }}</button>

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




@push('style')
    <style>
        .sp-replacer {
            padding: 0;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 5px 0 0 5px;
            border-right: none;
        }

        select.form-control:not([size]):not([multiple]) {
            height: calc(2.25rem + 9px);
        }

        .sp-preview {
            width: 100px;
            height: 46px;
            border: 0;
        }

        .sp-preview-inner {
            width: 110px;
        }

        .sp-dd {
            display: none;
        }

        .select2-container .select2-selection--single {
            height: 44px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 43px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px;
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('asset/admin/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script>
        $(function() {

            'use strict'

            $('#cp1').colorpicker();
            $('#cp2').colorpicker();

            $.uploadPreview({
                input_field: "#image-upload",
                preview_box: "#image-preview",
                label_field: "#image-label",
                label_default: "Choose File",
                label_selected: "Update Image",
                no_label: false,
                success_callback: null
            });

            $.uploadPreview({
                input_field: "#image-upload-icon",
                preview_box: "#image-preview-icon",
                label_field: "#image-label-icon",
                label_default: "Choose File",
                label_selected: "Update Image",
                no_label: false,
                success_callback: null
            });

            $.uploadPreview({
                input_field: "#image-upload-login",
                preview_box: "#image-preview-login",
                label_field: "#image-label-login",
                label_default: "Choose File",
                label_selected: "Update Image",
                no_label: false,
                success_callback: null
            });

            $.uploadPreview({
                input_field: "#image-upload-login_image",
                preview_box: "#image-preview-login_image",
                label_field: "#image-label-login_image",
                label_default: "Choose File",
                label_selected: "Update Image",
                no_label: false,
                success_callback: null
            });

            $.uploadPreview({
                input_field: "#image-upload-breadcrumbs",
                preview_box: "#image-preview-breadcrumbs",
                label_field: "#image-label-breadcrumbs",
                label_default: "Choose File",
                label_selected: "Update Image",
                no_label: false,
                success_callback: null
            });

            $.uploadPreview({
                input_field: "#image-upload-main",
                preview_box: "#image-preview-main",
                label_field: "#image-label-main",
                label_default: "Choose File",
                label_selected: "Update Image",
                no_label: false,
                success_callback: null
            });

            $.uploadPreview({
                input_field: "#image-upload-whitelogo",
                preview_box: "#image-preview-whitelogo",
                label_field: "#image-label-whitelogo",
                label_default: "Choose File",
                label_selected: "Update Image",
                no_label: false,
                success_callback: null
            });
        })
    </script>
@endpush
