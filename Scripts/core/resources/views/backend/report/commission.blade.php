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
                            <div class="card-body p-2">

                                <table class="table table-striped table-md" id="myTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('Commison From') }}</th>
                                            <th scope="col">{{ __('Commison To') }}</th>
                                            <th scope="col">{{ __('Amount') }}</th>
                                            <th scope="col">{{ __('Commision Date') }}</th>
                                        </tr>

                                    </thead>
                                    <tbody id="appendFilter">

                                        @forelse ($commison as $item)
                                            <tr>
                                                <td data-caption="From">{{ @$item->parent->username }}</td>
                                                <td data-caption="From">{{ @$item->child->username }}</td>
                                                <td data-caption="To">{{ number_format($item->amount, 2) }}
                                                    {{ @$general->site_currency }}</td>
                                                <td data-caption="{{ __('date') }}">
                                                    {{ $item->created_at->format('y-m-d') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td data-caption="Data" class="text-center" colspan="100%">
                                                    {{ __('No Data Found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>


                                   

                                </table>

                            </div>

                            <div class="card-footer">
                                {{ $commison->links('backend.partial.paginate') }}
                            </div>
                        </div>
                    </div>
                </div>
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
        
         th,td{
            text-align: center !important;
        }
    </style>
@endpush

@push('script')
    <script>
        $(function() {
            'use strict'
            $('#myTable').DataTable({
                paging: false,
                info: false
            });
        })
    </script>
@endpush
