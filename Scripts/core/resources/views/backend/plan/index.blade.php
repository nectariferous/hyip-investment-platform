@extends('backend.layout.master')


@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header justify-content-end">
                            <a href="{{ route('admin.plan.create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i>
                                {{ __('Add Plan') }}</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>

                                            <th>{{ __('SL') }}.</th>
                                            <th>{{ __('Plan Name') }}</th>
                                            <th>{{ __('Invest Limit') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($plans as $plan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $plan->plan_name }}</td>
                                                <td>
                                                    @if ($plan->amount_type == 0)
                                                        {{ number_format($plan->minimum_amount, 0) . ' ' . @$general->site_currency }}
                                                        -
                                                        {{ number_format($plan->maximum_amount, 0) . ' ' . @$general->site_currency }}
                                                    @else
                                                        {{ number_format($plan->amount, 0) . ' ' . @$general->site_currency }}
                                                    @endif

                                                </td>

                                                <td>
                                                    <div class="custom-switch custom-switch-label-onoff">
                                                        <input class="custom-switch-input status"
                                                            id="test-{{ $plan->id }}"
                                                            data-status="{{ $plan->status }}"
                                                            data-url="{{ route('admin.plan.changestatus', $plan->id) }}"
                                                            type="checkbox" name="status"
                                                            {{ $plan->status ? 'checked' : '' }}>
                                                        <label class="custom-switch-btn"
                                                            for="test-{{ $plan->id }}"></label>
                                                    </div>

                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.plan.edit', $plan->id) }}"
                                                        class="btn btn-md btn-primary"><i class="fa fa-pen mr-2"></i
                                                            class="fa fa-pen mr-2"></i>{{ __('Edit') }}</a>
                                                </td>
                                            </tr>
                                        @empty

                                            <tr>
                                                <td class="text-center" colspan="100%">
                                                    {{ __('No Plan Created Yet') }}</td>
                                            </tr>
                                        @endforelse


                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if ($plans->hasPages())
                            <div class="card-footer">
                                {{ $plans->links('backend.partial.paginate') }}
                            </div>
                        @endif


                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection


@push('script')
    <script>
        'use strict'

        $(function() {

            $('.status').on('change', function() {

                let status = $(this).data('status');
                let url = $(this).data('url');

                $.ajax({

                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },

                    url: url,

                    data: {
                        status: status
                    },

                    method: "POST",

                    success: function(response) {
                        iziToast.success({

                            message: response.success,
                            position: 'topRight'
                        });
                    }
                })
            })

        })
    </script>
@endpush
