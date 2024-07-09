@extends('backend.layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __($pageTitle) }}</h4>
                                <div class="card-header-form">

                                    <div class="d-flex justify-content-between">
                                        <form action="" method="get" class="d-inline-flex">
                                            <input type="text" name="trx" class="form-control me-2" placeholder="transaction id">
                                            <input type="date" class="form-control me-3" placeholder="Search User" name="date">
                                            <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                                        </form>
                                    </div>

                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="table-responsive">
                                   

                                    <table class="table table-striped table-md">
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
                                                    <td data-caption="{{ __('Trx') }}">
                                                        {{ $transaction->transaction_id }}</td>

                                                    <td data-caption="{{ __('Sender') }}">
                                                        <p class="p-0 m-0">
                                                            Name : {{ @$transaction->sender->full_name }}
                                                        </p>
                                                        <p class="p-0 m-0">
                                                            Email : {{ @$transaction->sender->email }}
                                                        </p>
                                                    </td>

                                                    <td data-caption="{{ __('Receiver') }}">
                                                        <p class="p-0 m-0">
                                                            Name : {{ @$transaction->receiver->full_name }}
                                                        </p>
                                                        <p class="p-0 m-0">
                                                            Email : {{ @$transaction->receiver->email }}
                                                        </p>
                                                    </td>

                                                    <td data-caption="{{ __('Amount') }}">
                                                        {{ number_format($transaction->amount, 2) }}</td>
                                                    <td data-caption="{{ __('Currency') }}">{{ $general->site_currency }}
                                                    </td>
                                                    <td data-caption="{{ __('Charge') }}">
                                                        {{ number_format($transaction->charge, 2) . ' ' . $general->site_currency }}
                                                    </td>
                                                    <td data-caption="{{ __('Details') }}">{{ $transaction->details }}
                                                    </td>
                                                    <td data-caption="{{ __('Payment Date') }}">
                                                        {{ $transaction->created_at->format('Y-m-d') }}
                                                    </td>
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
                                </div>

                            </div>

                            <div class="card-footer">
                                {{ $transfers->links('backend.partial.paginate') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


@push('style')
    <style>
        .ranges {
            padding: 10px !important;
            margin-top: 10px !important;
        }

        .daterangepicker .ranges li.active {
            background-color: #6777ee !important;
        }

        .daterangepicker .ranges li:hover {
            background-color: #f5f5f5 !important;
            color: #6777ee;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
        }

        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 4px #ddd solid;
            border-top: 4px #068cfa solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style>
@endpush




@push('script')
    <script>
        'use strict'
        $(function() {

            $('.daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            }, function(start, end) {
                $('.daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'))
            });


            $('.ranges ul li').each(function(index) {
                $(this).on('click', function() {
                    let key = $(this).data('range-key')
                    $("#overlay").fadeIn(300);
                    $.ajax({
                        url: "{{ route('admin.payment.report') }}",
                        data: {
                            key: key
                        },
                        method: "GET",
                        success: function(response) {

                            $('#filter_data').html(response);
                        },
                        complete: function() {
                            $("#overlay").fadeOut(300);
                        }

                    })


                })
            })

            $(document).on('click', '.applyBtn', function() {
                let dateStrat = $('input[name=daterangepicker_start]').val()
                let dateEnd = $('input[name=daterangepicker_end]').val()
                let key = 'Custom Range'
                $("#overlay").fadeIn(300);
                $.ajax({
                    url: "{{ route('admin.payment.report') }}",
                    data: {
                        key: key,
                        startdate: dateStrat,
                        dateEnd: dateEnd
                    },
                    method: "GET",
                    success: function(response) {

                        $('#filter_data').html(response);
                    },
                    complete: function() {
                        $("#overlay").fadeOut(300);
                    }

                })
            })



        })
    </script>
@endpush
