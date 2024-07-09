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
                            <form method="POST" action="{{ route('admin.plan.update', $plan->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-row">

                                    <div class="form-group col-md-3">
                                        <label class="font-weight-bold">{{ __('Plan Name') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $plan->plan_name }}">
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
                                            <option {{ $plan->amount_type == 0 ? 'selected' : '' }} value="0">
                                                {{ __('Range') }}</option>
                                            <option {{ $plan->amount_type == 1 ? 'selected' : '' }} value="1">
                                                {{ __('Fixed') }}</option>
                                        </select>

                                    </div>


                                    <div class="form-group offman col-md-3" id="minimum">
                                        <label class="font-weight-bold">{{ __('Minimum Amount') }}<span
                                                class="text-danger">*</span></label></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="minimum" id="minimum_a"
                                                value="{{ $plan->minimum_amount ? $plan->minimum_amount : 0 }}">
                                            <div class="input-group-append">
                                                <div class="input-group-text">{{ @$general->site_currency }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group offman col-md-3" id="maximum">
                                        <label class="font-weight-bold">{{ __('Maximum Amount') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control maximum_a" name="maximum"
                                                id="maximum_a"
                                                value="{{ $plan->maximum_amount ? $plan->maximum_amount : 0 }}">
                                            <div class="input-group-append">
                                                <div class="input-group-text">{{ @$general->site_currency }}</div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group onman col-md-3 amount">
                                        <label class="font-weight-bold"> {{ __('Amount') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="amount" id="amount"
                                                value="{{ $plan->amount ? $plan->amount : 0 }}">
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
                                            <input type="text" class="form-control" name="interest"
                                                value="{{ $plan->return_interest ? $plan->return_interest : 0 }}">
                                            <div class="input-group-append">
                                                <div class="input-group">
                                                    <select name="interest_status" class="form-control selectric">
                                                        <option
                                                            {{ $plan->interest_status == 'percentage' ? 'selected' : 'Percentage' }}
                                                            value="percentage">{{ __('Percentage') }}</option>
                                                        <option
                                                            {{ $plan->interest_status == 'fixed' ? 'selected' : 'Fixed' }}
                                                            value="fixed">{{ __('Fixed') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group col-md-3">
                                        <label class="font-weight-bold">{{ __('Every') }}</label>
                                        <select class="form-control selectric" name="times">
                                            @forelse ($time as $item)
                                                <option {{ $plan->every_time == $item->id ? 'selected' : '' }}
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                            @empty
                                            @endforelse


                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="font-weight-bold">{{ __('Return For') }}</label>
                                        <select name="return_for" class="form-control selectric" id="return_for">
                                            <option {{ $plan->return_for == '0' ? 'selected' : '' }} value="0">
                                                {{ __('Lifetime') }}</option>

                                            <option {{ $plan->return_for == '1' ? 'selected' : '' }} value="1">
                                                {{ __('Period') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group return col-md-3 how_many_times">
                                        <label class="font-weight-bold">{{ __('How Many Times') }}</label>
                                        <input type="text" class="form-control" name="repeat_time"
                                            value="{{ $plan->how_many_time ? $plan->how_many_time : 0 }}">
                                    </div>


                                    <div class="form-group col-md-3" id="capitalBack">
                                        <label class="font-weight-bold">{{ __('Capital Back') }}</label>
                                        <select name="capital_back" class="form-control selectric">

                                            <option {{ $plan->capital_back == '0' ? 'selected' : '' }} value="0">
                                                {{ __('No') }}</option>

                                            <option {{ $plan->capital_back == '1' ? 'selected' : '' }} value="1">
                                                {{ __('Yes') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="">User Invest Limit</label>
                                        <input type="text" class="form-control" name="limit" value="{{$plan->invest_limit}}">
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label class="font-weight-bold">{{ __('Status') }}</label>
                                        <select name="status" class="form-control selectric">
                                            <option {{ $plan->status == '0' ? 'selected' : '' }} value="0">
                                                {{ __('Disable') }}</option>

                                            <option {{ $plan->status == '1' ? 'selected' : '' }} value="1">
                                                {{ __('Active') }}</option>
                                        </select>
                                    </div>


                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
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


        $(function() {

            $('.how_many_times').hide();
            var amount_type = $('#amount_type').val();
            var return_period = $('#return_for').val();


            if (amount_type == 1) {
                $('#minimum').hide();
                $('#maximum').hide();

            }

            if (amount_type == 0) {
                $('#minimum').show();
                $('#maximum').show();
                $('.amount').hide();


            }

            if (return_period == 1) {
                $('.how_many_times').show();
                $('#capitalBack').show();

            } else {
                $('.how_many_times').hide();
                $('#capitalBack').hide();

            }


            $('#amount_type').on('change', function() {
                var value = $('#amount_type').val();

                if (value == 1) {
                    $('.amount').show();
                    $('#minimum').hide();
                    $('#maximum').hide();
                    $('#minimum_a').val('');
                    $('#maximum_a').val('');

                } else {
                    $('.amount').hide();
                    $('#minimum').show();
                    $('#maximum').show();
                    $('#amount').val('');

                }

            })

            $('#return_for').on('change', function() {

                var value = $('#return_for').val();

                if (value == 1) {
                    $('.how_many_times').show();
                    $('#capitalBack').show();

                } else {
                    $('.how_many_times').hide();
                    $('#capitalBack').hide();

                }

            })

        })
    </script>
@endpush
