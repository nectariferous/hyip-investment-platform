@extends('backend.layout.master')


@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>
            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('admin.plan.index') }}" class="btn btn-primary"><i
                                    class="fa fa-arrow-left mr-2"></i>{{ __('Back') }}</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.plan.store') }}">
                                @csrf
                                <div class="form-row">

                                    <div class="form-group col-md-3">
                                        <label class="font-weight-bold">{{ __('Plan Name') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') }}" placeholder="Plan name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                <span />
                                            @enderror
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label class="font-weight-bold">{{ __('Amount Type') }} <span
                                                class="text-danger">*</span></label></label>
                                        <select name="amount_type" class="form-control selectric" id="amount_type">
                                            <option value="0" selected>{{ __('Range') }}</option>
                                            <option value="1">{{ __('Fixed') }}</option>
                                        </select>

                                    </div>

                                    <div class="form-group offman col-md-3" id="minimum">
                                        <label class="font-weight-bold">{{ __('Minimum Amount') }}<span
                                                class="text-danger">*</span></label></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="minimum"
                                                value="{{ old('minimum') }}" placeholder="Minimum Amount">
                                            <div class="input-group-append">
                                                <div class="input-group-text">{{ @$general->site_currency }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group offman col-md-3" id="maximum">
                                        <label class="font-weight-bold">{{ __('Maximum Amount') }}</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="maximum"
                                                value="{{ old('maximum') }}" placeholder="Maximum Amount">
                                            <div class="input-group-append">
                                                <div class="input-group-text">{{ @$general->site_currency }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group onman col-md-3 amount">
                                        <label class="font-weight-bold"> {{ __('Amount') }}</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="amount"
                                                value="{{ old('amount') }}" placeholder="Amount">
                                            <div class="input-group-append">
                                                <div class="input-group-text">{{ @$general->site_currency }}</div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label class="font-weight-bold">{{ __('Return / Interest (Every Time)') }}
                                            <span class="text-danger">*</span></label>
                                        </label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="interest"
                                                placeholder="Interest rate">
                                            <div class="input-group-append">
                                                <div class="input-group">
                                                    <select name="interest_status" class="form-control selectric">
                                                        <option value="percentage">{{ __('Percentage') }}</option>
                                                        <option value="fixed">{{ __('Fixed') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label class="font-weight-bold">{{ __('Every') }}</label>
                                        <select class="form-control selectric" name="times">
                                            @forelse ($time as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @empty
                                                <p>{{ __('Time Not Found') }}</p>
                                            @endforelse

                                        </select>
                                    </div>



                                    <div class="form-group col-md-3">
                                        <label class="font-weight-bold">{{ __('Return For') }}</label>
                                        <select name="return_for" class="form-control selectric" id="return_for">
                                            <option value="0">{{ __('Lifetime') }}</option>
                                            <option value="1">{{ __('Period') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group return col-md-3 how_many_times">
                                        <label class="font-weight-bold">{{ __('How Many Times') }}</label>
                                        <input type="number" class="form-control" name="repeat_time"
                                            vlaue="{{ old('repeat_time') }}" placeholder="How many times" />
                                    </div>

                                    <div class="form-group col-md-3 capital_back" id="capitalBack">
                                        <label class="font-weight-bold">{{ __('Capital Back') }}</label>
                                        <select name="capital_back" class="form-control selectric">
                                            <option value="0">{{ __('No') }}</option>
                                            <option value="1">{{ __('Yes') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="">User Invest Limit</label>
                                        <input type="text" class="form-control" name="limit">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="font-weight-bold">{{ __('Status') }}</label>
                                        <select name="status" class="form-control selectric">
                                            <option value="0" selected>{{ __('Disable') }}</option>
                                            <option value="1">{{ __('Active') }}</option>
                                        </select>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Plan Create') }}</button>
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
        'use strict'
        $('.amount').hide();
        $('.how_many_times').hide();
        $('.capital_back').hide();

        $(function() {

            $('#return_for').on('change', function() {

                var value = $('#return_for').val();

                if (value == 1) {
                    $('.how_many_times').show();
                    $('.capital_back').show();
                } else {
                    $('.how_many_times').hide();
                    $('.capital_back').hide();

                }

            })


            $('#amount_type').on('change', function() {
                var value = $('#amount_type').val();

                if (value == 1) {
                    $('.amount').show();
                    $('#minimum').hide();
                    $('#maximum').hide();

                } else {
                    $('.amount').hide();
                    $('#minimum').show();
                    $('#maximum').show();
                }

            })

        })
    </script>
@endpush
