@extends('backend.layout.master')


@section('content')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>

            <div class="row">

                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Sl') }}</th>
                                            <th>{{ __('User') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Charge') }}</th>
                                            <th>{{ __('status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($manuals as $key => $manual)
                                            <tr>
                                                <td>{{ $key + $manuals->firstItem() }}</td>
                                                <td>{{$manual->user->fullname }}</td>
                                                <td>{{ number_format($manual->amount,2).' '.@$general->site_currency}}</td>
                                                <td>
                                                    {{ number_format($manual->charge, 2).' '.@$general->site_currency }}
                                                </td>
                                                <td>
                                                    @if ($manual->payment_status == 2)

                                                        <span class="badge badge-warning">{{ __('Pending') }}</span>

                                                    @elseif($manual->payment_status == 1)
                                                        <span
                                                            class="badge badge-success">{{ __('Approved') }}</span>


                                                    @elseif($manual->payment_status == 3)
                                                        <span
                                                            class="badge badge-danger">{{ __('Rejected') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-md btn-info details"
                                                        href="{{ route('admin.manual.trx', $manual->transaction_id) }}">{{ __('Details') }}</a>

                                                    @if ($manual->payment_status == 2)

                                                        <a class="btn text-white btn-md btn-primary accept"
                                                            data-url="{{ route('admin.manual.accept', $manual->transaction_id) }}">{{ __('Accept') }}</a>
                                                        <a class="btn text-white btn-md btn-danger reject"
                                                            data-url="{{ route('admin.manual.reject', $manual->transaction_id) }}">{{ __('Reject') }}</a>

                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="100%">{{ __('No Data Found') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($manuals->hasPages())
                            {{ $manuals->links('backend.partial.paginate') }}
                        @endif
                    </div>
                </div>
            </div>

        </section>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="accept" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <form action="" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Payment Accept') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <p>{{ __('Are you sure to Accept this Payment request') }}?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                            data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Accept') }}</button>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <form action="" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Payment Reject') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <p>{{ __('Are you sure to reject this payment') }}?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Reject') }}</button>

                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection


@push('script')

    <script>
        $(function() {
            'use strict'


            $('.accept').on('click', function() {
                const modal = $('#accept');

                modal.find('form').attr('action', $(this).data('url'));
                modal.modal('show');
            })

            $('.reject').on('click', function() {
                const modal = $('#reject');

                modal.find('form').attr('action', $(this).data('url'));
                modal.modal('show');
            })

        })
    </script>

@endpush
