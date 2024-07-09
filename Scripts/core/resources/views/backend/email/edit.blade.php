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
                        <div class="card-body">
                            <div class="card-header">
                                <h5>{{ __('Variables Meaning') }}</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>{{ __('Variable') }}</th>
                                        <th>{{ __('Meaning') }}</th>
                                    </tr>

                                    @foreach ($template->meaning as $key => $temp)
                                        <tr>

                                            <td>{{ '{' . $key . '}' }}</td>
                                            <td>{{ $temp }}</td>

                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="" method="post">

                                @csrf

                                <div class="row">


                                    <div class="form-group col-md-12">

                                        <label for="">{{ __('Subject') }}</label>
                                        <input type="text" name="subject" class="form-control"
                                            value="{{ $template->subject }}">


                                    </div>

                                    <div class="form-group col-md-12">

                                        <label for="">{{ __('Template') }}</label>
                                        <textarea name="template" class="form-control summernote">{{ clean($template->template) }}</textarea>

                                    </div>


                                    <div class="col-md-12">
                                        <button type="submit"
                                            class="btn btn-primary float-right">{{ __('Update Email Template') }}</button>
                                    </div>


                                </div>



                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


@push('script')
    <script>
        $(function() {
            'use strict'
            $('.summernote').summernote();
        })
    </script>
@endpush
