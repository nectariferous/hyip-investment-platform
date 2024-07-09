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
                            <h4></h4>
                            <div class="card-header-form">
                                <form>
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Search">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Support Id') }}</th>
                                            <th>{{ __('Customer') }}</th>
                                            <th>{{ __('Subject') }}</th>
                                            <th>{{ __('Status') }}</th>
                                           
                                            <th>{{ __('Created At') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse(@$tickets as $ticket)
                                            <tr>
                                                <td scope="row"><b>{{ $ticket->support_id }}</b></td>
                                                <td>{{ @$ticket->user->fullname }}</td>
                                                <td>{{ $ticket->subject }}</td>
                                                <td>
                                                    @if ($ticket->status == 1)<span class="badge badge-danger"> {{ __('Closed') }} </span> @endif
                                                    @if ($ticket->status == 2)<span class="badge badge-warning"> {{ __('Pending') }} </span> @endif
                                                    @if ($ticket->status == 3)<span class="badge badge-success"> {{ __('Answered') }}</span> @endif
                                                </td>
                                               
                                                <td>{{ $ticket->created_at }}</td>
                                                <td>
                                                    <a class="btn btn-md btn-primary btn-action"
                                                        href="{{ route('admin.ticket.show', @$ticket->id) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button data-href="{{ route('admin.ticket.destroy', @$ticket->id) }}"
                                                        class="btn btn-md btn-danger delete_confirm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">{{ __('NO TICKET FOUND') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($tickets->hasPages())
                            <div class="card-footer">
                                {{ $tickets->links('backend.partial.paginate') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Start:: Delete Modal-->
    <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST">
                @csrf
                {{ method_field('DELETE') }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Delete') }} </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row col-md-12">
                            <p>{{ __('Are you sure to delete ?') }}</p>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-danger" type="submit">{{ __('Delete') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End:: Delete Modal-->
@endsection

@push('script')
    <script>
        'use strict'
        $('.delete_confirm').on('click', function() {
            const modal = $('#delete_modal')

            modal.find('form').attr('action', $(this).data('href'))
            modal.modal('show');
        })
    </script>
@endpush
