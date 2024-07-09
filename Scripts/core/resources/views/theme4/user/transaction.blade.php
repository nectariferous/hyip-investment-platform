@extends(template().'layout.master2')


@section('content2')
    <div class="dashboard-body-part">

        <div class="mobile-page-header">
            <h5 class="title">{{ __('Transaction History') }}</h5>
            <a href="{{ route('user.dashboard') }}" class="back-btn"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
        </div>

        <div class="site-card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h5 class="mb-sm-0 mb-2">{{ __('Transaction Log') }}</h5>
                <form action="" method="get">
                    <div class="row g-3">
                        <div class="col-auto">
                            <input type="text" name="trx" class="form-control form-control-sm" placeholder="transaction id">
                        </div>
                        <div class="col-auto">
                            <input type="date" class="form-control form-control-sm" placeholder="Search User" name="date">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn main-btn btn-sm">{{__('Search')}}</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table site-table">
                        <thead>
                            <tr>
                                <th>{{ __('Trx') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Gateway') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Currency') }}</th>
                                <th>{{ __('Charge') }}</th>
                                <th>{{ __('Details') }}</th>
                                <th>{{ __('Payment Date') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($transactions as $key => $transaction)
                                <tr>
                                    <td data-caption="{{ __('Trx') }}">{{ $transaction->trx }}</td>
                                    <td data-caption="{{ __('User') }}">{{ @$transaction->user->fname . ' ' . @$transaction->user->lname }}</td>
                                    <td data-caption="{{ __('Gateway') }}">{{ @$transaction->gateway->gateway_name ?? 'Account Transfer' }}</td>
                                    <td data-caption="{{ __('Amount') }}">{{ $transaction->amount }}</td>
                                    <td data-caption="{{ __('Currency') }}">{{ $transaction->currency }}</td>
                                    <td data-caption="{{ __('Charge') }}">{{ $transaction->charge . ' ' . $transaction->currency }}</td>
                                    <td data-caption="{{ __('Details') }}">{{ $transaction->details }}</td>
                                    <td data-caption="{{ __('Payment Date') }}">{{ $transaction->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">
                                        {{ __('No Transaction Found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($transactions->hasPages())
                        {{ $transactions->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
