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
                        <div class="card-header justify-content-between">

                            <div class="d-flex flex-wrap">

                                <?= filterByVariousType([
                                        'model' => 'Role',
                                        'text' => [
                                            'placeholder' => 'Search Name',
                                            'name' => 'search',
                                            'id' => 'search_text',
                                            'filter_colum' => 'name'
                                        ],
                                        
                                    ]) ?>

                            </div>

                            <button data-href="{{ route('admin.roles.create') }}" class="btn btn-primary add"> <i
                                    class="fa fa-plus"></i>
                                {{ __('Add Role') }}</button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>

                                            <th>{{ __('SL') }}.</th>
                                            <th>{{ __('Role Name') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="filter_data">

                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>

                                                    <button class="btn btn-primary btn-sm edit"
                                                        data-name="{{ $role->name }}"
                                                        data-href="{{ route('admin.roles.update', $role) }}"
                                                        data-permissons="{{ $role->permissions->pluck('name') }}">
                                                        <i class="fa fa-pen"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if ($roles->hasPages())
                            <div class="card-footer">
                                {{ $roles->links('backend.partial.paginate') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </section>
    </div>


    <div class="modal fade" id="role" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.roles.store') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Create Role') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">{{ __('Role Name') }}</label>
                            <input type="text" name="role" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Role Permission') }}</label>
                            <select name="permission[]" class="js-example-tokenizer" multiple>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i>
                            {{ __('Create Role') }}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa fa-times"></i>
                            {{ __('Close') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <div class="modal fade" id="role_edit" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="" method="post">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Create Role') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">{{ __('Role Name') }}</label>
                            <input type="text" name="role" required class="form-control">
                        </div>

                        <select name="permission[]" class="js-example-tokenizer form-control" multiple id="edit_select">
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i>
                            {{ __('Update Role') }}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa fa-times"></i>
                            {{ __('Close') }}</button>
                    </div>
                </div>
            </form>
        </div>
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


                modal.find('#edit_select').val($(this).data('permissons'));

                modal.find('#edit_select').trigger('change')



                modal.modal('show')
            })

        })
    </script>
@endpush
