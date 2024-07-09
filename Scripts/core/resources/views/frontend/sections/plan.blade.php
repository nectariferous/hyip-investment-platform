@php
$content = content('plan.content');
$plans = App\Models\Plan::where('status', 1)
    ->latest()
    ->get();
@endphp

<section class="s-pt-100 s-pb-100 dark-bg">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="site-header">
                    <h2 class="site-title">{{ __(@$content->data->title) }}</h2>
                </div>
            </div>
        </div>

        <div class="row gy-4">
            @forelse ($plans as $plan)
                @php
                    $plan_exist = App\Models\Payment::where('plan_id', $plan->id)
                        ->where('user_id', Auth::id())
                        ->where('next_payment_date', '!=', null)
                        ->where('payment_status', 1)
                        ->count();
                    
                @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="invest-plan">
                        <div class="invest-plan-shape"></div>
                        <div class="invest-plan-top">
                            <h4 class="invest-plan-name">{{ $plan->plan_name }}</h4>
                            <h5 class="invest-plan-amount">{{ number_format($plan->return_interest, 2) }} @if ($plan->interest_status == 'percentage')
                                    {{ '%' }}
                                @else
                                    {{ @$general->site_currency }}
                                @endif
                            </h5>
                            <p class="mb-0">{{ __('Every') }} {{ $plan->time->name }}</p>
                        </div>

                        <div class="invest-plan-middle">
                            <h5 class="invest-plan-min-max">
                                @if ($plan->amount_type == 0)
                                    {{ __('Min') }}
                                    {{ number_format($plan->minimum_amount, 2) . ' ' . @$general->site_currency }}
                                    <p class="mb-0">-</p>
                                    {{ __('Max') }}
                                    {{ number_format($plan->maximum_amount, 2) . ' ' . @$general->site_currency }}
                                @else
                                    {{ number_format($plan->amount, 2) . ' ' . @$general->site_currency }}
                                @endif
                            </h5>
                            <ul class="invest-plan-features">
                                <li>

                                    @if ($plan->return_for == 1)
                                        {{ __('For') }} {{ $plan->how_many_time }}
                                        {{ __('Times') }}
                                    @else
                                        {{ __('Lifetime') }}
                                    @endif

                                </li>

                            

                                @if ($plan->capital_back == 1)
                                    <li>{{ __('Capital Back') }} {{ __('YES') }}</li>
                                @else
                                    <li>{{ __('Capital Back') }} {{ __('NO') }}</li>
                                @endif
                            </ul>

                            <h6 class="mt-4 mb-3">{{ __('Affiliate Bonus') }}</h6>
                            <ul class="plan-referral justify-content-center">
                                @if($plan->referrals)
                                    @foreach ($plan->referrals->level as $key => $value)
                                        <div class="single-referral">
                                            <span>{{$plan->referrals->commision[$key]}} %</span>
                                            <p>{{$value}}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="invest-plan-action mt-3">
                            @if ($plan_exist >= $plan->invest_limit)
                                    <a class="sp_theme_btn w-100" href="#">{{ __('Max Invest Limit exceeded') }}</a>
                            @else
                                <a class="sp_theme_btn w-100 mb-3"
                                    href="{{ route('user.gateways', $plan->id) }}">{{ __('Invest Now') }}</a>
                                    @auth
                                        
                                    <button class="sp_theme_btn w-100 balance" data-plan="{{ $plan }}" data-url="">{{ __('Invest Using Balance') }}</button>
                                    @endauth
                                    
                            @endif
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
</section>

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
                    <button type="button" class="sp_btn sp_btn_secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="sp_btn sp_theme_btn">{{__('Invest Now')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>

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
