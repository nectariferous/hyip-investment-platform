@extends('backend.layout.master')


@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>
            <div class="card">
                <div class="card-body p-2">

                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th>{{ __('Sl') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Plan Name') }}</th>
                                <th>{{ __('Interest Amount') }}</th>
                                <th>{{ __('How Many Time get Paid') }}</th>
                                <th>{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($interestLogs as  $interestLog)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ @$interestLog->user->fname }} {{ @$interestLog->user->lname }}</td>
                                    <td>{{ @$interestLog->payment->plan->plan_name }}</td>
                                    <td>{{ number_format($interestLog->interest_amount, 2) . ' ' . @$general->site_currency }}
                                    </td>
                                    <td>{{ @$interestLog->payment->pay_count }} {{ __(' Out of ') }}
                                        {{ @$interestLog->payment->plan->how_many_time }} {{ __('Times') }}
                                    </td>
                                    <td>{{ $interestLog->created_at }}</td>
                                </tr>

                            @empty

                                <tr>

                                    <td class="text-center" colspan="100%">{{ __('No Data Found') }}</td>

                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>

                @if ($interestLogs->hasPages())
                    <div class="card-footer">
                        {{ $interestLogs->links('backend.partial.paginate') }}
                    </div>
                @endif

            </div>
        </section>
    </div>
@endsection


@push('style-plugin')
    <link rel="stylesheet" href="{{ asset('asset/admin/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/bs4-datatable.min.css') }}">
@endpush

@push('script-plugin')
    <script src="{{ asset('asset/admin/js/datatables.min.js') }}"></script>
    <script src="{{ asset('asset/admin/js/bs4-datatable.min.js') }}"></script>
@endpush

@push('style')
    <style>
        .pagination .page-item.active .page-link {
            background-color: rgb(95, 116, 235);
            border: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: transparent;
            border-color: transparent;
        }

        .pagination .page-item.active .page-link:hover {
            background-color: rgb(95, 116, 235);
        }

        th,
        td {
            text-align: center !important;
        }
    </style>
@endpush

@push('script')
    <script>
        $(function() {
            'use strict'
            $('#myTable').DataTable();
        })
    </script>
@endpush
