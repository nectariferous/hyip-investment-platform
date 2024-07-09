@extends(template().'layout.master2')

@section('content2')
<div class="dashboard-body-part">

    <div class="mobile-page-header">
        <h5 class="title">{{ __('Investment') }}</h5>
        <a href="{{ route('user.dashboard') }}" class="back-btn"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
    </div>

    <div class="row gy-4 items-wrapper justify-content-center">
        @forelse ($plans as $plan)
            @php
                $plan_exist = App\Models\Payment::where('plan_id', $plan->id)
                    ->where('user_id', Auth::id())
                    ->where('next_payment_date', '!=', null)
                    ->where('payment_status', 1)
                    ->count();
            @endphp
            <div class="col-xxl-4 col-xl-6 col-md-6"> 
                <div class="plan-item plan-item-two"> 
                    <h3 class="plan-name mb-3">{{ $plan->plan_name }}</h3> 
                    <div class="plan-percentage"> 
                        <span class="plan-amount"> 
                            {{ number_format($plan->return_interest, 2) }} @if ($plan->interest_status == 'percentage')
                                {{ '%' }}
                            @else
                                {{ @$general->site_currency }}
                            @endif
                        </span>
                        <span class="plan-status">{{ $plan->time->name }}</span>
                    </div>
                    <ul class="plan-list my-5">
                        @if ($plan->amount_type == 0) 
                            <li>
                                <span class="caption">{{ __('Minimum') }} </span>
                                <span class="details"> {{ number_format($plan->minimum_amount, 2) . ' ' . @$general->site_currency }}</span>
                            </li>
                            <li>
                                <span class="caption">{{ __('Maximum') }} </span>
                                <span class="details"> {{ number_format($plan->maximum_amount, 2) . ' ' . @$general->site_currency }}</span>
                            </li>
                        @else
                            <li>
                                <span class="caption">{{ __('Amount') }} </span>
                                <span class="details"> {{ number_format($plan->amount, 2) . ' ' . @$general->site_currency }}</span>
                            </li>
                        @endif  

                        @if ($plan->return_for == 1)
                            <li>
                                <span class="caption">{{ __('For') }} </span>
                                <span class="details"> {{ $plan->how_many_time }} {{ __('Times') }}</span>
                            </li>
                        @else
                            <li>
                                <span class="caption">{{ __('For') }} </span>
                                <span class="details"> {{ __('Lifetime') }}</span>
                            </li>
                        @endif

                        @if ($plan->capital_back == 1)
                            <li>
                                <span class="caption">{{ __('Capital Back') }} </span>
                                <span class="details"> {{ __('YES') }}</span>
                            </li>
                        @else
                            <li>
                                <span class="caption">{{ __('Capital Back') }} </span>
                                <span class="details"> {{ __('NO') }}</span>
                            </li>
                        @endif
                    </ul>
                    <div class="mt-auto">
                        <h6 class="mb-3 text-center">{{ __('Affiliate Bonus') }}</h6>
                        <ul class="plan-referral justify-content-center mb-2">
                            @if($plan->referrals)
                                @foreach ($plan->referrals->level as $key => $value)
                                    <div class="single-referral">
                                        <span>{{$plan->referrals->commision[$key]}} %</span>
                                        <p>{{$value}}</p>
                                    </div>
                                @endforeach
                            @endif
                        </ul>
                        
                        @if ($plan_exist >= $plan->invest_limit)
                            <a class="btn main-btn plan-btn w-100 disabled" href="#">{{ __('Max Limit exceeded') }}</a>
                        @else
                            <a class="btn main-btn plan-btn w-100" href="{{ route('user.gateways', $plan->id) }}">{{ __('Invest Now') }}</a>
                            @auth 
                            <button class="btn main-btn plan-btn balance w-100 mt-3" data-plan="{{ $plan }}"
                                data-url="">{{ __('Invest Using Balance') }}</button>
                            @endauth 
                        @endif
                    </div>
                </div>
            </div>
        @empty
        @endforelse
    </div>
</div>


<div class="modal fade" id="invest" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('user.investmentplan.submit')}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Invest Now')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="">{{ __('Invest Amount') }}</label>
                            <input type="text" name="amount" class="form-control">
                            <input type="hidden" name="plan_id" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn sp_btn_success">{{__('Invest Now')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
    <script>
        $(function() {
            'use strict'

            $('.balance').on('click', function() {
                const modal = $('#invest');
                modal.find('input[name=plan_id]').val($(this).data('plan').id);
                modal.modal('show')
            })
        })
    </script>
@endpush
