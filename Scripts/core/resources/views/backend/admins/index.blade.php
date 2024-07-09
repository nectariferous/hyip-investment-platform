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

                            <div class="d-flex flex-wrap">

                                <?= filterByVariousType([
                                        'model' => 'Admin',
                                        'text' => [
                                            'placeholder' => 'Search Username',
                                            'name' => 'search',
                                            'id' => 'search_text',
                                            'filter_colum' => 'username',
                                        ],
                                    ]) ?>

                            </div>


                            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary add me-2"> <i
                                    class="fa fa-plus"></i>
                                {{ __('Create Admin') }}</a>


                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>

                                            <th>{{ __('SL') }}.</th>
                                            <th>{{ __('Role Name') }}</th>
                                            <th>{{ __('Username') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="filter_data">

                                        @foreach ($admins as $admin)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @foreach ($admin->roles as $role)
                                                        <span class="badge badge-primary">{{ $role->name }}</span>
                                                    @endforeach
                                                </td>

                                                <td>{{ $admin->username }}</td>
                                                <td>{{ $admin->email }}</td>

                                                <td>
                                                    <a href="{{ route('admin.admins.edit', $admin) }}"
                                                        class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
                                                </td>

                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if ($admins->hasPages())
                            <div class="card-footer">
                                {{ $admins->links('backend.partial.paginate') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@push('style-plugin')
    <link rel="stylesheet" href="{{ asset('asset/admin/css/select2.min.css') }}">
@endpush

@push('script-plugin')
    <script src="{{ asset('asset/admin/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict'

        $(function() {


            $(".js-example-tokenizer").select2({
                placeholder: "Give Permission",
                tags: true,
                tokenSeparators: [',', ' ']
            })

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


            $('.add').on('click', function() {
                const modal = $('#role')


                modal.modal('show')
            })


            $('.edit').on('click', function() {
                const modal = $('#role_edit')

                modal.find('input[name=role]').val($(this).data('name'));

                modal.find('form').attr('action', $(this).data('href'));


                modal.find('.js-example-tokenizer').val($(this).data('permission')).trigger('change')

                // modal.find('.js-example-tokenizer').select2().trigger('change')


                modal.modal('show')
            })

        })
    </script>
@endpush
