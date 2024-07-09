@extends('backend.layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>


            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card b-radius-10 ">
                        <div class="card-header d-flex justify-content-between">
                            <button type="button" data-toggle="modal" data-target="#adModal"
                                class="btn btn-primary mr-3 mt-2"><i class="fa fa-plus"></i>{{__('Ad New')}}</button>

                            <form action="" method="GET" class="form-inline float-sm-right bg-white mt-2">
                                <div class="input-group has_append">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="{{__('Search by ad size')}}" value="{{ $search ?? '' }}" autocomplete="off">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive-md  table-responsive">
                                <table class="table table-light style-two">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{__('Advertisement Type')}}</th>
                                            <th scope="col">{{__('Ad Size')}}</th>
                                            <th scope="col">{{__('Ad Image')}}</th>
                                            <th scope="col">{{__('Status')}}</th>
                                            <th scope="col">{{__('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($advertisements as $advr)
                                            <tr>
                                                <td data-label="{{__('Advertisement Type')}}"><span
                                                        class="badge {{ $advr->type == 1 ? 'badge-success' : 'badge-primary' }}">{{ $advr->type == 1 ? 'Banner' : 'Script' }}</span>
                                                </td>
                                                <td data-label=">{{__('Resolution')}}"><span
                                                        class=" badge badge-primary">{{ $advr->resolution }}</span>
                                                </td>
                                                @if ($advr->type == 1)
                                                    <td data-label="{{__('Ad Image')}}"> <a class="btn btn-sm btn-dark glightbox"
                                                            href="{{ asset('asset/images/advertisement/'.$advr->ad_image) }}"> <i class="fa fa-eye"></i>
                                                            {{__('see')}}</a>
                                                    </td>
                                                @else
                                                    <td {{__('Ad Image')}}> {{__('N/A')}}</td>
                                                @endif


                                                <td data-label="{{__('Status')}}"><span
                                                        class="badge {{ $advr->status == 1 ? 'badge-success' : 'badge-warning' }}">{{ $advr->status == 1 ? 'active' : 'inactive' }}</span>
                                                </td>

                                                <td data-label="Action">
                                                    <a href="javascript:void(0)" data-advr="{{ $advr }}"
                                                        data-route="{{ route('admin.advertisements.update', $advr->id) }}"
                                                        class="btn btn-sm btn-primary mr-2 edit" data-toggle="tooltip"
                                                        title="{{__('Edit')}}">
                                                        <i class="fa fa-pen text-shadow"></i>
                                                    </a>
                                                    <a href="javascript:void(0)"
                                                        data-route="{{ route('admin.advertisements.remove', $advr->id) }}"
                                                        class="btn btn-sm btn-danger delete" data-toggle="tooltip"
                                                        title="{{__('Delete')}}">
                                                        <i class="fa fa-trash text-shadow"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table><!-- table end -->
                            </div>
                        </div>
                        <div class="card-footer py-4">
                            {{ $advertisements->links() }}
                        </div>
                    </div><!-- card end -->
                </div>



            </div>
        </section>
    </div>

    <div class="modal fade" id="adModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.advertisements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">{{__('Ad new advertisement')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{__('Select Type')}}</label>
                            <select class="form-control type" name="type" required>
                                <option value="1">{{__('Banner')}}</option>
                                <option value="2">{{__('Script')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{__('Select Ad Size')}}</label>
                            <select class="form-control" name="size" required>
                                <option value="728x90">{{__('728x90')}}</option>
                                <option value="300x250">{{__('300x250')}}</option>
                                <option value="300x600">{{__('300x600')}}</option>
                                <option value="970x250">{{__('970x250')}}</option>
                            </select>
                        </div>
                        <div class="form-group ru">
                            <label>{{__('Redirect Url')}}</label>
                            <input type="text" class="form-control" name="redirect_url" placeholder="https://example.com"
                                required value="{{ old('redirect_url') }}">
                        </div>

                        <div class="form-group adfile">
                            <label>{{__('Ad Image')}}</label>
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                <input type="file" class="form-control-file" name="adimage" required id="img">
                            </li>
                        </div>

                        <div class="form-group script d-none">
                            <label>{{__('Ad Script')}}</label>
                            <textarea type="text" class="form-control" disabled name="script" required>{{ old('script') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">{{__('Status')}} </label>
                            <input type="checkbox" name="status" 
                                data-toggle="toggle" data-on="Active" data-off="Disabled" data-onstyle="success"
                                data-offstyle="danger" data-width="100%" data-height="45">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">{{__('Edit Advertisement')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{__('Select Type')}}</label>
                            <select class="form-control type" name="type" required readonly>
                                <option value="1">{{__('Banner')}}</option>
                                <option value="2">{{__('Script')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{__('Select Ad Size')}}</label>
                            <select class="form-control" name="size" required>
                                <option value="728x90">{{__('728x90')}}</option>
                                <option value="300x250">{{__('300x250')}}</option>
                                <option value="300x600">{{__('300x600')}}</option>
                                <option value="970x250">{{__('970x250')}}</option>
                            </select>
                        </div>
                        <div class="form-group ru">
                            <label>{{__('Redirect Url')}}</label>
                            <input type="text" class="form-control" name="redirect_url"
                                placeholder="https://example.com" required value="{{ old('redirect_url') }}">
                        </div>

                        <div class="form-group adfile">
                            <label>{{__('Ad Image')}}</label>
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                <input type="file" class="form-control-file" name="adimage" id="img">
                            </li>
                        </div>

                        <div class="form-group script d-none">
                            <label>{{__('Ad Script')}}</label>
                            <textarea type="text" class="form-control" disabled name="script" required>{{ old('script') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">{{__('Status')}} </label>
                            <input type="checkbox" name="status" data-toggle="toggle" data-on="Active"
                                data-off="Disabled" data-onstyle="success" data-offstyle="danger" data-width="100%">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{-- delete modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close ml-auto m-3" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body text-center">

                        <i class="las la-exclamation-circle text-danger display-2 mb-15"></i>
                        <h4 class="text-secondary mb-15">{{__('Are You Sure Want to Delete This?')}}</h4>

                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('close')}}</button>
                        <button type="submit" class="btn btn-danger del">{{__('Delete')}}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection


@push('style-plugin')
    <link rel="stylesheet" href="{{ asset('asset/admin/css/toogle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/glightbox.min.css') }}">
@endpush

@push('script-plugin')
    <script src="{{ asset('asset/admin/js/toogle.min.js') }}"></script>
    <script src="{{ asset('asset/admin/js/glightbox.min.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        (function($) {
            const lightbox = GLightbox();
            $('.type').on("change", function() {
                if ($(this).val() == 1) {
                    $('.ru').removeClass('d-none')
                    $('.ru').find('input[name=redirect_url]').attr('disabled', false)
                    $('.adfile').removeClass('d-none')
                    $('.adfile').find('input[name=adimage]').attr('disabled', false)
                    $('.script').addClass('d-none')
                    $('.script').find('textarea[name=script]').attr('disabled', true)
                } else if ($(this).val() == 2) {
                    $('.ru').addClass('d-none')
                    $('.ru').find('input[name=redirect_url]').attr('disabled', true)
                    $('.previmage').addClass("d-none")
                    $('.adfile').addClass('d-none')
                    $('.adfile').find('input[name=adimage]').attr('disabled', true)
                    $('.script').removeClass('d-none')
                    $('.script').find('textarea[name=script]').attr('disabled', false)
                }
            })
            $('.edit').on('click', function() {
                var modal = $('#editModal')
                var advr = $(this).data('advr')
                var route = $(this).data('route')
                modal.find('select[name=type]').val(advr.type)
                modal.find('select[name=size]').val(advr.resolution)
                if (advr.redirect_url) {
                    modal.find('input[name=redirect_url]').val(advr.redirect_url)
                }
                if (advr.script != null) {
                    $('.ru').addClass('d-none')
                    $('.ru').find('input[name=redirect_url]').attr('disabled', true)
                    $('.previmage').addClass("d-none")
                    $('.adfile').addClass('d-none')
                    $('.adfile').find('input[name=adimage]').attr('disabled', true)
                    $('.script').removeClass('d-none')
                    $('.script').find('textarea[name=script]').attr('disabled', false)
                    modal.find('textarea[name=script]').val(advr.script)
                } else {
                    $('.ru').removeClass('d-none')
                    $('.ru').find('input[name=redirect_url]').attr('disabled', false)
                    $('.adfile').removeClass('d-none')
                    $('.adfile').find('input[name=adimage]').attr('disabled', false)
                    $('.script').addClass('d-none')
                    $('.script').find('textarea[name=script]').attr('disabled', true)
                }
                if (advr.status == 1) {
                    modal.find('input[name=status]').bootstrapToggle('on')
                }
                modal.find('form').attr('action', route)
                modal.modal('show')
            })
            $('.delete').on('click', function() {
                var route = $(this).data('route')
                var modal = $('#deleteModal');
                modal.find('form').attr('action', route)
                modal.modal('show');
            })
            // $('a[data-rel^=lightcase]').lightcase();
        })(jQuery);
    </script>
@endpush
