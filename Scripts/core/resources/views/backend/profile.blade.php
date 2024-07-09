@extends('backend.layout.master')

@section('content')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>

            <div class="row">

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <form method="post" action="{{ route('admin.change.password') }}">
                            @csrf
                            <div class="card-header">

                                <h6>{{ __('Change Password') }}</h6>

                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ __('Old Password') }}</label>
                                        <input type="password" class="form-control" value="123" name="old_password"
                                            required>
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ __('New Password') }}</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ __('Confirm Password') }}</label>
                                        <input type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">{{ __('Change Password') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <form method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                               

                                <div class="row">
                                    <div class="form-group col-md-8 mb-3">
                                        <label class="col-form-label">{{ __('Profile Image') }}</label>

                                        <div id="image-preview" class="image-preview"
                                            style="background-image:url({{ getFile('admin',auth()->guard('admin')->user()->image,
                                            ) }});">
                                            <label for="image-upload"
                                                id="image-label">{{ __('Choose File') }}</label>
                                            <input type="file" name="image" id="image-upload" />
                                        </div>

                                    </div>

                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ __('Email') }}</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ auth()->guard('admin')->user()->email }}" required>

                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label>{{ __('Username') }}</label>
                                        <input type="text" class="form-control" name="username"
                                            value="{{ auth()->guard('admin')->user()->username }}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">{{ __('Update Profile') }}</button>
                            </div>
                        </form>
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
            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "{{ __('Choose File') }}", // Default: Choose File
                label_selected: "{{ __('Update Image') }}", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });
        })
    </script>

@endpush
