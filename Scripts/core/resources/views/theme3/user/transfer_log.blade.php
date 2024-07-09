@extends(template() . 'layout.master2')


@section('content2')
    <div class="dashboard-body-part">

        <div class="mobile-page-header">
            <h5 class="title">{{ __('Money Transfer History') }}</h5>
            <a href="{{ route('user.dashboard') }}" class="back-btn"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
        </div>

        <div class="site-card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h5 class="mb-sm-0 mb-2">{{ __('Money Transfer Log') }}</h5>
                <form action="" method="get" class="d-inline-flex">
                    <input type="text" name="trx" class="form-control form-control-sm me-2" placeholder="transaction id">
                    <input type="date" class="form-control form-control-sm me-3" placeholder="Search User"
                        name="date">
                    <button type="submit" class="btn main-btn btn-sm">{{ __('Search') }}</button>
                </form>
            </div>

            <div class="card-body text-end">

                <div class="table-responsive">
                    <table class="table site-table">
                        <thead>
                            <tr>
                                <th>{{ __('Trx') }}</th>
                                <th>{{ __('Sender') }}</th>
                                <th>{{ __('Receiver') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Currency') }}</th>
                                <th>{{ __('Charge') }}</th>
                                <th>{{ __('Details') }}</th>
                                <th>{{ __('Payment Date') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($transfers as $key => $transaction)
                                <tr>
                                    <td data-caption="{{ __('Trx') }}">{{ $transaction->transaction_id }}</td>

                                    <td data-caption="{{ __('Sender') }}">
                                        <p class="p-0 m-0">
                                            Name : {{ $transaction->sender->full_name }}
                                        </p>
                                        <p class="p-0 m-0">
                                            Email : {{ $transaction->sender->email }}
                                        </p>
                                    </td>

                                    <td data-caption="{{ __('Receiver') }}">
                                        <p class="p-0 m-0">
                                            Name : {{ $transaction->receiver->full_name }}
                                        </p>
                                        <p class="p-0 m-0">
                                            Email : {{ $transaction->receiver->email }}
                                        </p>
                                    </td>

                                    <td data-caption="{{ __('Amount') }}">{{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td data-caption="{{ __('Currency') }}">{{ $general->site_currency }}</td>
                                    <td data-caption="{{ __('Charge') }}">
                                        {{ number_format($transaction->charge, 2) . ' ' . $general->site_currency }}</td>
                                    <td data-caption="{{ __('Details') }}">{{ $transaction->details }}</td>
                                    <td data-caption="{{ __('Payment Date') }}">
                                        {{ $transaction->created_at->format('Y-m-d') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center no-data-table" colspan="100%">
                                        {{ __('No Transaction Found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($transfers->hasPages())
                        {{ $transfers->links() }}
                    @endif
                </div>
            </div>

        </div>

    </div>
@endsection
