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
                                        <?= filterByVariousType([
                                                'model' => 'Payment',
                                                'text' => [
                                                    'placeholder' => 'Search Trx',
                                                    'name' => 'search',
                                                    'id' => 'search_text',
                                                    'filter_colum' => 'transaction_id',
                                                ],
                                            ]) ?>
                                        <form action="" class="ml-3">
                                            <div class="form-group">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-primary daterange-btn btn-d icon-left btn-icon filterData"><i
                                                        class="fas fa-calendar"></i> {{ __('Filter By Date') }}
                                                </a>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <thead>

                                            <tr>
                                                <th>{{ __('User') }}.</th>
                                                <th>{{ __('Gateway') }}</th>
                                                <th>{{ __('Trx') }}</th>
                                                <th>{{ __('Amount') }}</th>
                                                <th>{{ __('Rate') }}</th>
                                                <th>{{ __('Charge') }}</th>
                                                <th>{{ __('Final Amount') }}</th>
                                                <th>{{ __('Payment Type') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="filter_data">

                                            @forelse(@$transactions as $transaction)
                                                <tr>
                                                    <td>{{ @$transaction->user->fullname }}</td>
                                                    <td>{{ @$transaction->gateway->gateway_name ?? 'Using Balance' }}</td>
                                                    <td>{{ @$transaction->transaction_id }}</td>
                                                    <td>{{ @number_format($transaction->amount, 2) }}</td>
                                                    <td>{{ @number_format($transaction->rate, 2) }}</td>
                                                    <td>{{ @number_format($transaction->charge, 2) }}</td>
                                                    <td>{{ @number_format($transaction->final_amount, 2) }}</td>
                                                    <td>
                                                        @if ($transaction->payment_type == 1)
                                                            <span class="badge badge-success">{{ __('Autometic') }}</span>
                                                        @else
                                                            <span class="badge badge-info">{{ __('Manual') }}</span>
                                                        @endif
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">{{ __('No Data Found') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>

                                    </table>
                                </div>

                            </div>

                            <div class="card-footer">
                                {{ $transactions->links('backend.partial.paginate') }}
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
