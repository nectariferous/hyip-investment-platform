@extends('backend.layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <form action="" method="post" enctype="multipart/form-data">

                        @csrf
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mr-3">

                                    {{ __('Php Mail Settings') }}

                                    @if ($general->email_method === 'php')
                                        <i class="far fa-check-circle text-success ft-40"></i>
                                    @else
                                        <i class="far fa-times-circle text-danger ft-40"></i>
                                    @endif

                                </h5>

                                @if ($general->email_method != 'php')
                                    <div>

                                        <button type="submit"
                                            class="btn btn-primary">{{ __('Update Email Configuration') }}</button>

                                    </div>
                                @endif


                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">


                                    <input type="hidden" name="email_method" value="php">

                                    <div class="form-group col-md-4">

                                        <label for="">{{ __('Email Sent From') }}</label>

                                        <input type="email" name="site_email" class="form-control form_control"
                                            value="{{ @$general->site_email }}">

                                    </div>



                                </div>

                            </div>
                        </div>
                    </form>
                </div>


                <div class="col-12 col-md-12 col-lg-12">
                    <form action="" method="post" enctype="multipart/form-data">

                        @csrf
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mr-3">

                                    {{ __('SMTP Mail Settings') }}

                                    @if ($general->email_method === 'smtp')
                                        <i class="far fa-check-circle text-success ft-40"></i>
                                    @else
                                        <i class="far fa-times-circle text-danger ft-40"></i>
                                    @endif

                                </h5>

                                @if ($general->email_method != 'smtp')
                                    <div>

                                        <button type="submit"
                                            class="btn btn-primary float-right">{{ __('Update Email Configuration') }}</button>

                                    </div>
                                @endif

                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <input type="hidden" name="email_method" value="smtp">
                                    <div class="col-md-4 my-3">

                                        <label for="">{{ __('Email Sent From') }}</label>

                                        <input type="email" name="site_email" class="form-control form_control"
                                            value="{{ @$general->site_email }}">

                                    </div>

                                    <div class="col-md-4 my-3">

                                        <label for="">{{ __('SMTP HOST') }}</label>
                                        <input type="text" name="email_config[smtp_host]" class="form-control"
                                            value="{{ @$general->email_config->smtp_host }}">

                                    </div>

                                    <div class="col-md-4 my-3">

                                        <label for="">{{ __('SMTP Username') }}</label>
                                        <input type="text" name="email_config[smtp_username]" class="form-control"
                                            value="{{ @$general->email_config->smtp_username }}">

                                    </div>

                                    <div class="col-md-4 my-3">

                                        <label for="">{{ __('SMTP Password') }}</label>
                                        <input type="password" name="email_config[smtp_password]" class="form-control"
                                            value="{{ @$general->email_config->smtp_password }}">

                                    </div>
                                    <div class="col-md-4 my-3">

                                        <label for="">{{ __('SMTP port') }}</label>
                                        <input type="text" name="email_config[smtp_port]" class="form-control"
                                            value="{{ @$general->email_config->smtp_port }}">

                                    </div>

                                    <div class="col-md-4 my-3">

                                        <label for="">{{ __('SMTP Encryption') }}</label>
                                        <select name="email_config[smtp_encryption]" id="encryption"
                                            class="form-control selectric">
                                            <option value="ssl"
                                                {{ @$general->email_config->smtp_encryption == 'ssl' ? 'selected' : '' }}>
                                                {{ __('SSL') }}</option>
                                            <option value="tls"
                                                {{ @$general->email_config->smtp_encryption == 'tls' ? 'selected' : '' }}>
                                                {{ __('TLS') }}</option>
                                        </select>

                                        <code class="hint"></code>

                                    </div>

                                </div>




                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </section>
    </div>
@endsection

@push('style')
    <style>
        .ft-40 {
            font-size: 20px;
        }
    </style>
@endpush


@push('script')
    <script>
        $(function() {
            'use strict'


            $(document).on('change', '#encryption', function() {

                if ($(this).val() == 'ssl') {
                    $('.hint').text("For SSL please add ssl:// before host otherwise it won't work")
                } else {
                    $('.hint').text('')
                }
            })
        })
    </script>
@endpush
