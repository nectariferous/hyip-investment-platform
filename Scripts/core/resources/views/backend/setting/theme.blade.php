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

                            <table class="table table-striped" id="myTable">
                                <thead>
                                    <tr>
                                        <th>{{ __('Theme') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('Previw') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h5>

                                                {{ __('Gold Theme') }}
                                            </h5>
                                            <p>
                                                <a data-route="{{ route('admin.manage.theme.update', 1) }}"
                                                    class="@if ($general->theme != 1) btn btn-outline-danger btn-sm active-btn @endif  @if ($general->theme == 1) text-success @else text-danger @endif font-weight-bolder">
                                                    @if ($general->theme == 1)
                                                        {{__('Activeted')}}
                                                    @else
                                                        {{__('Active')}}
                                                    @endif
                                                </a>
                                            </p>


                                        </td>
                                        <td>{{__('Gold Theme')}}</td>
                                        <td>
                                            <button data-href="https://hyipmaxone.springsoftit.com/"
                                                class="btn btn-primary btn-sm prev">
                                                {{__('Preview')}}
                                            </button>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <h5>

                                                {{ __('Green Theme') }}
                                            </h5>
                                            <p>
                                                <a data-route="{{ route('admin.manage.theme.update', 2) }}"
                                                    class="@if ($general->theme != 2) btn btn-outline-danger btn-sm active-btn @endif @if ($general->theme == 2) text-success @else text-danger @endif font-weight-bolder ">
                                                    @if ($general->theme == 2)
                                                        {{('Activeted')}}
                                                    @else
                                                        Active
                                                    @endif
                                                </a>
                                            </p>
                                        </td>
                                        <td>{{__('Green Theme')}}</td>
                                        <td>
                                            <button data-href="https://hyipmaxtwo.springsoftit.com/"
                                                class="btn btn-primary btn-sm prev">
                                                {{__('Preview')}}
                                            </button>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <h5>

                                                {{ __('White Theme') }}
                                            </h5>
                                            <p>
                                                <a data-route="{{ route('admin.manage.theme.update', 3) }}"
                                                    class="@if ($general->theme != 3) btn btn-outline-danger btn-sm active-btn @endif @if ($general->theme == 3) text-success @else text-danger @endif font-weight-bolder">
                                                    @if ($general->theme == 3)
                                                        {{__('Activated')}}
                                                    @else
                                                        {{__('Active')}}
                                                    @endif
                                                </a>
                                            </p>
                                        </td>
                                        <td>{{__('White Theme')}}</td>
                                        <td>
                                            <button data-href="https://hyipmaxthree.springsoftit.com/"
                                                class="btn btn-primary btn-sm prev">
                                                {{__('Preview')}}
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <h5>

                                                {{ __('Purple Theme') }}
                                            </h5>
                                            <p>
                                                <a data-route="{{ route('admin.manage.theme.update', 4) }}"
                                                    class="@if ($general->theme != 4) btn btn-outline-danger btn-sm active-btn @endif @if ($general->theme == 4) text-success @else text-danger @endif font-weight-bolder">
                                                    @if ($general->theme == 4)
                                                        {{__('Activated')}}
                                                    @else
                                                        {{__('Active')}}
                                                    @endif
                                                </a>
                                            </p>
                                        </td>
                                        <td>{{__('Red Theme')}}</td>
                                        <td>
                                            <button data-href="https://hyipmaxthree.springsoftit.com/"
                                                class="btn btn-primary btn-sm prev">
                                                {{__('Preview')}}
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="activeTheme" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Active Template') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            {{ __('Are you sure to active this template ?') }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Active') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="prev" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal--w" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Template Preview') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <iframe src="" frameborder="0" id="iframe"></iframe>




                </div>

            </div>

        </div>
    </div>
@endsection

@push('script')
    <style>
        .modal-dialog {
            max-width: 96% !important;
        }

        #iframe {
            width: 100%;
            height: 100vh;
        }
    </style>
@endpush

@push('script')
    <script>
        $(function() {
            'use strict'

            $('.active-btn').on('click', function() {
                const modal = $('#activeTheme');

                modal.find('form').attr('action', $(this).data('route'))

                modal.modal('show')
            })


            $('.prev').on('click', function() {
                const modal = $('#prev');

                modal.find('iframe').attr('src', $(this).data('href'))

                modal.modal('show')
            })
        })
    </script>
@endpush
