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

  <section class="transaction-section sp_pt_120 sp_pb_120 sp_separator_bg" style="background-image: url('{{ asset('asset/theme3/images/bg/bg4.jpg') }}');">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-7 text-center">
          <div class="sp_site_header  wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
            <h2 class="sp_site_title">{{ __(@$content->data->title) }}</h2>
          </div>
        </div>
      </div>
      <div class="row">
          <div class="col-lg-12">
            <div class="transaction-wrapper">
              <div class="transaction-wrapper-top mb-4">
                <h4 class="title">{{ __('Transaction history') }}</h4>
                <ul class="nav nav-pills transaction-tabs" id="pills-tab" role="tablist">
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
              
              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane table-content fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                  <table class="table site-table">
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
                                  <td data-caption="{{ __('Gateway') }}">{{ @$item->gateway->gateway_name ?? 'Deposit' }}
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
                  <table class="table site-table">
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
      </div>
    </div>
  </section>