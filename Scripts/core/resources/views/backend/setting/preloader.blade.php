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
                            <form action="" method="post" enctype="multipart/form-data">

                                @csrf

                                <div class="row">

         

                                    <div class="form-group col-md-7">

                                        <label for="">{{ __('Allow Preloader') }}</label>

                                        <select name="preloader_status" id="" class="form-control selectric">

                                            <option value="1" {{ @$general->preloader_status ? 'selected' : '' }}>
                                                {{ __('Yes') }}</option>
                                            <option value="0" {{ @$general->preloader_status ? '' : 'selected' }}>
                                                {{ __('No') }}</option>

                                        </select>

                                    </div>

                                    <div class="form-group col-md-12">

                                        <button type="submit" class="btn btn-primary float-left">{{ __('Preloader Update') }}</button>

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


            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "{{ __('Choose File') }}", // Default: Choose File
                label_selected: "{{ __('Update Image') }}", // Default: Change File
                no_label: true, // Default: false
                success_callback: null // Default: null
            });
        })
    </script>

@endpush
