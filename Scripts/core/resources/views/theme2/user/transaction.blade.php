@extends(template().'layout.master2')


@section('content2')
    <div class="dashboard-body-part">
        <div class="card-body text-end">
            <form action="" method="get" class="d-inline-flex">
                <input type="text" name="trx" class="form-control me-2" placeholder="transaction id">
                <input type="date" class="form-control me-3" placeholder="Search User" name="date">
                <button type="submit" class="sp_theme_btn">{{__('Search')}}</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table sp_site_table">
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
                                {{ __('No users Found') }}
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
@endsection
