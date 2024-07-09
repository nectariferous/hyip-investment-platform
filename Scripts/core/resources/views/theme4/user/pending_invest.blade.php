@extends(template().'layout.master2')


@section('content2')
    <div class="dashboard-body-part">
        <div class="site-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table site-table">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Plan Name') }}</th>
                                <th scope="col">{{ __('Get Paid') }}</th>
                                <th scope="col">{{ __('Interest') }}</th>
                                <th scope="col">{{ __('Invest Amount') }}</th>
                                <th scope="col">{{ __('Invest Date') }}</th>
                                <th scope="col">{{ __('Next Payment Date') }}</th>
                                <th scope="col">{{ __('Payment Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $plan)
                                <tr>
                                    <td data-caption="Plan Name">{{ @$plan->plan->plan_name }}</td>
                                    <td data-caption="Get Paid">
                                        @if ($plan->plan->return_for == 1)
                                            {{ isset($plan->pay_count) ? $plan->pay_count : $plan->plan->how_many_time }}
                                            {{ __(' Out of ') }}
                                            {{ $plan->plan->how_many_time }} {{ __('Times') }}
                                        @else
                                            {{ __('Lifetime') }}
                                        @endif
                                    </td>
                                    <td data-caption="Interest">{{ number_format($plan->interest_amount, 2) }}
                                        {{ @$general->site_currency }}</td>
                                    <td data-caption="Invest Amount">{{ number_format($plan->amount, 2) }} {{ @$general->site_currency }}</td>
                                    <td data-caption="Invest Date">{{ $plan->created_at }}</td>
                                    <td data-caption="Next Payment Date">
                                        @if ($plan->payment_status == 1)
                                            {{ @$plan->next_payment_date }}
                                        @else
                                            {{'N/A'}}
                                        @endif
                                    </td>
                                    <td data-caption="Payment Status">

                                        @if ($plan->payment_status == 1)
                                            <span class="sp_badge sp_badge_success">{{ __('Success') }}</span>
                                        @elseif($plan->payment_status == 2)
                                            <span class="sp_badge sp_badge_warning">{{ __('Pending') }}</span>
                                        @elseif($plan->payment_status == 3)
                                            <span class="sp_badge sp_badge_danger">{{ __('Rejected') }}</span>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td data-caption="Not Found" class="text-center" colspan="100%">{{ __('No Data Found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
