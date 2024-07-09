@extends(template() . 'layout.master2')

@section('content2')
    <div class="dashboard-body-part">

        <div class="mobile-page-header">
            <h5 class="title">{{ __('Tranfer Money') }}</h5>
            <a href="{{ route('user.dashboard') }}" class="back-btn"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="site-card">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('Transfer Money') }}</h4>
                        <p class="mb-0">Current Balance :
                            {{ number_format(auth()->user()->balance, 2) . ' ' . $general->site_currency }}</p>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="">{{ __('Receiver Email') }}</label>
                                <input type="text" name="email" id="refer-link" class="form-control"
                                    placeholder="Transfer account email" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">{{ __('Amount') }}</label>
                                <input type="text" name="amount" id="amount" class="form-control"
                                    placeholder="Transfer Amount" data-type="{{ $general->trans_type }}"
                                    data-charge="{{ $general->trans_charge }}" required>

                                <p id="totalAmount" class="sp_text_secondary mt-3"></p>
                            </div>

                            <p class="text-center mb-3">{{ __('Transfer Charge') }} {{ $general->trans_charge . ' ' . ($general->trans_type === 'fixed' ? $general->site_currency : '%') }}</p>

                            <ul class="list-group mb-4">
                                <li class="list-group-item d-flex flex-wrap align-items-center justify-content-between px-0 border-0 py-0">
                                    <span>{{ __('Min Transfer Amount') }}</span>
                                    <span>{{ $general->min_amount . ' ' . $general->site_currency }}</span>
                                </li>
                                <hr>
                                <li class="list-group-item d-flex flex-wrap align-items-center justify-content-between px-0 border-0 py-0">
                                    <span>{{ __('Max Transfer Amount') }}</span>
                                    <span>{{ $general->max_amount . ' ' . $general->site_currency }}</span>
                                </li>
                            </ul>

                            <button type="submit" class="btn main-btn w-100" id="basic-addon2">{{ __('Transfer Money') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            let commission = 0;
            let total = 0;

            $('#amount').on('keyup', function() {

                if($(this).val() == ''){
                    $('#totalAmount').text('')
                    return
                }

                if (/\D/g.test(this.value)) {

                    this.value = this.value.replace(/\D/g, '');

                    return
                }

                let charge = $(this).data('charge');

                if ($(this).data('type') === 'percent') {
                    commission = (parseFloat($(this).val()) * parseFloat(charge)) / 100;
                } else {
                    commission = parseFloat(charge)
                }

                total = parseFloat($(this).val()) + commission;


                $('#totalAmount').text('Total Amount with Charge - ' + total)



            })
        })
    </script>
@endpush
