@extends(template() . 'layout.master2')

@section('content2')



    <div class="dashboard-body-part">

      


        <div class="row gy-4">


            <div class="col-xxl-5">
                <div class="d-box-one h-100">
                    <div class="icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="content">
                        <span class="caption-title">{{ __('Account Balance') }}</span>
                        <h3 class="d-box-one-amount">
                            {{ number_format(auth()->user()->balance, 2) . ' ' . $general->site_currency }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xxl-7">
                <div class="row gy-4">
                    <div class="col-sm-6">
                        <div class="d-box-three">
                            <div class="icon">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <div class="content">
                                <span class="caption-title">{{ __('Total Withdraw') }}</span>
                                <h3 class="d-box-three-amount">
                                    {{ number_format($withdraw, 2) . ' ' . $general->site_currency }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-box-three">
                            <div class="icon">
                                <i class="fas fa-funnel-dollar"></i>
                            </div>
                            <div class="content">
                                <span class="caption-title">{{ __('Total Deposit') }}</span>
                                <h3 class="d-box-three-amount">
                                    {{ number_format($totalDeposit, 2) . ' ' . $general->site_currency }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-box-three">
                            <div class="icon">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div class="content">
                                <span class="caption-title">{{ __('Current Invest') }}</span>
                                <h3 class="d-box-three-amount">
                                    {{ isset($currentInvest->amount) ? number_format($currentInvest->amount, 2) : 0 }}
                                    {{ @$general->site_currency }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-box-three">
                            <div class="icon">
                                <i class="far fa-calendar-check"></i>
                            </div>
                            <div class="content">
                                <span class="caption-title">{{ __('Current Plan') }}</span>
                                <h3 class="d-box-three-amount">
                                    {{ isset($currentPlan->plan->plan_name) ? $currentPlan->plan->plan_name : 'N/A' }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 mt-2 d-box-four-wrapper">
            <div class="col-xxl-3 col-sm-6">
                <div class="d-box-four">
                    <a href="{{ route('user.invest.all') }}" class="link-btn"><i class="bi bi-arrow-up-right"></i></a>
                    <div class="icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="content">
                        <span class="caption-title">{{ __('Total Invest') }}</span>
                        <h3 class="d-box-four-amount">
                            {{ number_format($totalInvest, 2) . ' ' . $general->site_currency }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="d-box-four">
                    <a href="{{ route('user.invest.pending') }}" class="link-btn"><i class="bi bi-arrow-up-right"></i></a>
                    <div class="icon">
                        <i class="fas fa-hourglass-start"></i>
                    </div>
                    <div class="content">
                        <span class="caption-title">{{ __('Pending Invest') }}</span>
                        <h3 class="d-box-four-amount">
                            {{ number_format($pendingInvest, 2) . ' ' . $general->site_currency }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="d-box-four">
                    <a href="{{ route('user.withdraw.pending') }}" class="link-btn"><i
                            class="bi bi-arrow-up-right"></i></a>
                    <div class="icon">
                        <i class="fas fa-hourglass-end"></i>
                    </div>
                    <div class="content">
                        <span class="caption-title">{{ __('Pending Withdraw') }}</span>
                        <h3 class="d-box-four-amount">
                            {{ number_format($pendingWithdraw, 2) . ' ' . $general->site_currency }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="d-box-four">
                    <a href="{{ route('user.commision') }}" class="link-btn"><i class="bi bi-arrow-up-right"></i></a>
                    <div class="icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <div class="content">
                        <span class="caption-title">{{ __('Refferal Earn') }}</span>
                        <h3 class="d-box-four-amount">{{ number_format($commison, 2) }}
                            {{ @$general->site_currency }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <label>{{ __('Your refferal link') }}</label>
            <div class="input-group mb-3">
                <input type="text" id="refer-link" class="form-control copy-text"
                    value="{{ route('user.register', @Auth::user()->username) }}" placeholder="referallink.com/refer"
                    aria-label="Recipient's username" aria-describedby="basic-addon2" readonly>
                <button type="button" class="input-group-text copy sp_theme_btn" id="basic-addon2">{{ __('Copy') }}</button>
            </div>
        </div>


        @php
            $reference = auth()->user()->refferals;
        @endphp
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('Reference Tree') }}</h5>
                    </div>
                    <div class="card-body">
                        @if ($reference->count() > 0)
                            <ul class="sp-referral">
                                <li class="single-child root-child">
                                    <p>
                                        <img src="{{ getFile('user', auth()->user()->image) }}">
                                        <span class="mb-0">{{ auth()->user()->full_name .' - '. currentPlan(auth()->user())}}</span>
                                    </p>
                                    <ul class="sub-child-list step-2">
                                        @foreach ($reference as $user)
                                            <li class="single-child">
                                                <p>
                                                    <img src="{{ getFile('user', $user->image) }}">
                                                    <span class="mb-0">{{ $user->full_name.' - '. currentPlan($user) }}</span>
                                                </p>

                                                <ul class="sub-child-list step-3">
                                                    @foreach ($user->refferals as $ref)
                                                        <li class="single-child">
                                                            <p>
                                                                <img src="{{ getFile('user', $ref->image) }}">
                                                                <span class="mb-0">{{ $ref->full_name.' - '. currentPlan($ref) }}</span>
                                                            </p>

                                                            <ul class="sub-child-list step-4">
                                                                @foreach ($ref->refferals as $ref2)
                                                                    <li class="single-child">
                                                                        <p>
                                                                            <img src="{{ getFile('user', $ref2->image) }}">
                                                                            <span
                                                                                class="mb-0">{{ $ref2->full_name.' - '. currentPlan($ref2) }}</span>
                                                                        </p>
                                                                    </li>
                                                                @endforeach
                                                            </ul>

                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach

                                    </ul>
                                </li>
                            </ul>
                        @else
                            <div class="col-md-12 text-center mt-5">
                                <i class="far fa-sad-tear display-1"></i>
                                <p class="mt-2">
                                    {{ __('No Reference User Found') }}
                                </p>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="modal fade" id="planDelete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Plan</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach (auth()->user()->payments()->where('payment_status', 1)->get() as $pay)
                            <div class="form-group site-radio">

                                <input type="radio" name="plan" value="{{ $pay->plan->id }}"
                                    id="planDeletelabel-{{ $loop->iteration }}">

                                <label for="planDeletelabel-{{ $loop->iteration }}">
                                    {{ $pay->plan->plan_name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('style')
    <style>

.modal-backdrop.fade.show {
            display: none;
        }

        .sp-referral .single-child {
            padding: 6px 10px;
            border-radius: 5px;
        }

        .sp-referral .single-child+.single-child {
            margin-top: 15px;
        }

        .sp-referral .single-child p {
            display: flex;
            align-items: center;
            margin-bottom: 0;
        }

        .sp-referral .single-child p img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            -o-object-fit: cover;
        }

        

        .sp-referral .single-child p span {
            width: calc(100% - 35px);
            font-size: 14px;
            padding-left: 10px;
        }

        .sub-child-list {
            position: relative;
            padding-left: 35px;
        }

        .sub-child-list::before {
            position: absolute;
            content: '';
            top: 0;
            left: 17px;
            width: 1px;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sp-referral>.single-child.root-child>.sub-child-list::before {
            background-color: var(--main-color);
        }

        .sub-child-list>.single-child {
            position: relative;
        }

        .sub-child-list>.single-child::before {
            position: absolute;
            content: '';
            left: -18px;
            top: 21px;
            width: 30px;
            height: 5px;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0 0 0 5px;
        }

        .sp-referral>.single-child.root-child > p img  {
            border: 2px solid #5463ff;
        }

        .sub-child-list.step-2 > .single-child > p img {
            border: 2px solid #0aa27c;
        }
        .sub-child-list.step-3 > .single-child > p img {
            border: 2px solid #a20a0a;
        }
        .sub-child-list.step-4 > .single-child > p img {
            border: 2px solid #f562e6;
        }
        .sub-child-list.step-5 > .single-child > p img {
            border: 2px solid #a20a0a;
        }



    </style>
@endpush


@push('script')
    <script>
        'use strict';

        $('.planDelete').on('click', function() {
            const modal = $('#planDelete');

            modal.find('form').attr('action', $(this).data('href'))

            modal.modal('show')


        })


        var copyButton = document.querySelector('.copy');
        var copyInput = document.querySelector('.copy-text');
        copyButton.addEventListener('click', function(e) {
            e.preventDefault();
            var text = copyInput.select();
            document.execCommand('copy');
        });
        copyInput.addEventListener('click', function() {
            this.select();
        });
    </script>
@endpush
