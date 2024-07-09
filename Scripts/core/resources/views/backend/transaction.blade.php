@extends('backend.layout.master')


@section('content')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>


            <div class="row">
                <div class="col-md-12">

                    
                    
                    <div class="card">
                        <div class="card-header">
                            <form action="" method="GET">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control"  name="dates">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary"
                                            type="submit">{{ __('Filter Transaction') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
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
                                                <td>{{ $transaction->trx }}</td>
                                                <td>{{ @$transaction->user->fname .' '.@$transaction->user->lname }}</td>
                                                <td>{{ @$transaction->gateway->gateway_name ?? 'Account Transfer' }}</td>
                                                <td>{{ $transaction->amount }}</td>
                                                <td>{{ $transaction->currency }}</td>
                                                <td>{{ $transaction->charge . ' ' . $transaction->currency }}</td>
                                                <td>{{ $transaction->details }}</td>
                                                <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
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
                            </div>
                        </div>

                        @if ($transactions->hasPages())
                            <div class="card-footer">

                                {{ $transactions->links('backend.partial.paginate') }}

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection


@push('style')

<style>

.card .card-header .form-control{
    border-radius: 0;
}

.card .card-header .btn:not(.note-btn){
    border-radius: 0;
}

</style>
    
@endpush

@push('script')

    <script>
        $(function() {
            'use strict'

            $('input[name="dates"]').daterangepicker();

        })
    </script>

@endpush
