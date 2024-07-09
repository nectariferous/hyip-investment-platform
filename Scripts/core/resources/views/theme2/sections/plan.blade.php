@php
$content = content('plan.content');
$plans = App\Models\Plan::where('status', 1)
    ->latest()
    ->get();
@endphp

<section id="investment" class="s-pt-100 s-pb-100 separator-bg">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="sp_site_header">
                    <h2 class="sp_site_title">{{ __(@$content->data->title) }}</h2>
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

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="0.5s">
                    <div class="pricing-item">
                        <div class="top-part">
                            <div class="icon">
                                <i class="las la-gem"></i>
                            </div>
                            <div class="plan-name">
                                <span>{{ $plan->plan_name }}</span>
                            </div>
                            @if ($plan->amount_type == 0)
                                <h4 class="plan-price">
                                    {{ __('Min') }}
                                    {{ number_format($plan->minimum_amount, 2)}} <sub>/ {{ @$general->site_currency }}</sub>
                                </h4>
                                <h4 class="plan-price">
                                    {{ __('Max') }}
                                    {{ number_format($plan->maximum_amount, 2) }} <sub>/ {{ @$general->site_currency }}</sub>
                                </h4>
                            @else
                                <h4 class="plan-price">
                                    {{ number_format($plan->amount, 2) }} <sub>/ {{ @$general->site_currency }}</sub>
                                </h4>
                            @endif

                            <ul class="check-list">
                                <li>{{ __('Every') }} {{ $plan->time->name }}</li>
                                <li>{{ __('Return Amount ') }}{{ number_format($plan->return_interest, 2) }}
                                    @if ($plan->interest_status == 'percentage')
                                        {{ '%' }}
                                    @else
                                        {{ @$general->site_currency }}
                                    @endif
                                </li>
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
                            <ul class="plan-referral">
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
                        <div class="bottom-part">
                            @if ($plan_exist >= $plan->invest_limit)
                                    <a class="sp_theme_btn w-100" href="#">{{ __('Max Invest Limit exceeded') }}</a>
                            @else
                                <a class="sp_theme_btn w-100 "
                                    href="{{ route('user.gateways', $plan->id) }}">{{ __('Choose Plan') }}</a>
                                    
                                    @auth
                                        
                                    <button class="sp_theme_btn w-100 balance mt-3" data-plan="{{ $plan }}"
                                        data-url="">{{ __('Invest Using Balance') }}</button>
                                    @endauth
                            @endif
                            
                        </div>
                    </div><!-- pricing-item end -->
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn sp_theme_btn">{{__('Invest Now')}}</button>
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
