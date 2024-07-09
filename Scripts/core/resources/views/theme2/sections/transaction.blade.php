@php
$content = content('transaction.content');
$recentTransactions = App\Models\Payment::with('user', 'gateway')
                                        ->latest()
                                        ->where('payment_status',1)
                                        ->limit(10)
                                        ->get();
$recentwithdraw = App\Models\Withdraw::with('user', 'withdrawMethod')
                                      ->latest()
                                      ->where('status',1)
                                      ->limit(10)
                                      ->get();

@endphp


<section class="transaction-section s-pt-100 s-pb-100">
    <div class="transaction-candle">
        <img src="{{ getFile('bg', 'transaction.png') }}" alt="image">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="sp_site_header">
                    <h2 class="sp_site_title">{{ __(@$content->data->title) }}</h2>
                </div>
            </div>
        </div>

        <div class="transaction-wrapper">
            <div class="transaction-el">
                <img src="{{getFile('bg', 'bitcoin.png')}}" alt="image">
            </div>
            <div class="transaction-wrapper-top">
                <h4>{{ __('Transaction History') }}</h4>
                <div class="text-center">
                    <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">{{ __('Latest Invests') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false">{{ __('Latest Withdraws') }}</button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane table-content fade show active" id="pills-home" role="tabpanel"
                    aria-labelledby="pills-home-tab">

                    <table class="table sp_site_table">
                        <thead>
                            <tr class="bg-yellow">
                                <th scope="col">{{ __('Username') }}</th>
                                <th scope="col">{{ __('Date') }}</th>
                                <th scope="col">{{ __('Amount') }}</th>
                                <th scope="col">{{ __('Gateway') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentTransactions as $item)
                                <tr>
                                    <td data-caption="{{ __('Username') }}">{{ @$item->user->username }}</td>
                                    <td data-caption="{{ __('Date') }}">
                                        {{ $item->created_at->format('Y-m-d') }}</td>
                                    <td data-caption="{{ __('Amount') }}">
                                        {{ number_format($item->amount, 2) . ' ' . @$general->site_currency }}</td>
                                    <td data-caption="{{ __('Gateway') }}">{{ @$item->gateway->gateway_name?? 'Deposit' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td data-caption="{{ __('Status') }}" class="text-center" colspan="100%">
                                        {{ __('No Data Found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <table class="table sp_site_table">
                        <thead>
                            <tr class="bg-yellow">
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Date') }}</th>
                                <th scope="col">{{ __('Amount') }}</th>
                                <th scope="col">{{ __('Gateway') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentwithdraw as $item)
                                <tr>
                                    <td data-caption="{{ __('Name') }}">{{ @$item->user->username }}</td>
                                    <td data-caption="{{ __('Date') }}">
                                        {{ $item->created_at->format('Y-m-d') }}</td>
                                    <td data-caption="{{ __('Amount') }}">
                                        {{ number_format($item->withdraw_amount, 2) . ' ' . @$general->site_currency }}
                                    </td>
                                    <td data-caption="{{ __('Gateway') }}">{{ $item->withdrawMethod->name }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td data-caption="{{ __('Status') }}" class="text-center" colspan="100%">
                                        {{ __('No Data Found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section><!-- End Transaction Section -->
