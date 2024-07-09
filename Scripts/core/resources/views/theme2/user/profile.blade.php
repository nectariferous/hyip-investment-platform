@extends(template().'layout.master2')


@section('content2')
    <div class="dashboard-body-part">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('user.change.password') }}" class="sp_theme_btn mb-2">{{ __('Change Password') }}</a>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('user.profileupdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-4 justify-content-center">
                        <div class="col-md-4 pe-lg-5 pe-md-4 justify-content-center">
                            <div class="img-choose-div">
                                <p>{{ __('Profile Picture') }}</p>

                                    <img class=" rounded file-id-preview w-100" id="file-id-preview"
                                        src="{{ getFile('user', @Auth::user()->image) }}" alt="pp">

                                <input type="file" name="image" id="imageUpload" class="upload"
                                    accept=".png, .jpg, .jpeg" hidden>

                                <label for="imageUpload"
                                    class="editImg sp_theme_btn w-100">{{ __('Choose file') }}</label>


                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="update">
                                <div class="mb-3">
                                    <label>{{ __('First Name') }}</label>
                                    <input type="text" class="form-control" name="fname"
                                        value="{{ @Auth::user()->fname }}"
                                        placeholder="{{ __('Enter First Name') }}">
                                </div>
                                <div class="mb-3">
                                    <label>{{ __('Last Name') }}</label>
                                    <input type="text" class="form-control" name="lname"
                                        value="{{ @Auth::user()->lname }}"
                                        placeholder="{{ __('Enter Last Name') }}">
                                </div>
                                <div class="mb-3">
                                    <label>{{ __('Username') }}</label>
                                    <input type="text" class="form-control text-white" name="username"
                                        value="{{ @Auth::user()->username }}"
                                        placeholder="{{ __('Enter User Name') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>{{ __('Email address') }}</label>
                                <input type="email" class="form-control" name="email"
                                    value="{{ @Auth::user()->email }}" placeholder="{{ __('Enter Email') }}">
                            </div>

                            <div class="mb-3">
                                <label>{{ __('Phone') }}</label>
                                <input type="text" class="form-control" name="phone"
                                    value="{{ @Auth::user()->phone }}" placeholder="{{ __('Enter Phone') }}">
                            </div>


                            <div class="row">

                                <div class="form-group col-md-6 mb-3 ">
                                    <label>{{ __('Country') }}</label>
                                    <input type="text" name="country" class="form-control"
                                        value="{{ @Auth::user()->address->country }}">
                                </div>

                                <div class="col-md-6 mb-3">

                                    <label>{{ __('city') }}</label>
                                    <input type="text" name="city" class="form-control form_control"
                                        value="{{ @Auth::user()->address->city }}">

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label>{{ __('zip') }}</label>
                                    <input type="text" name="zip" class="form-control form_control"
                                        value="{{ @Auth::user()->address->zip }}">

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label>{{ __('state') }}</label>
                                    <input type="text" name="state" class="form-control form_control"
                                        value="{{ @Auth::user()->address->state }}">

                                </div>

                            </div>

                            <button class="sp_theme_btn mt-3 w-100">{{ __('Update') }}</button>
                        </div>




                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        'use strict'
        document.getElementById("imageUpload").onchange = function() {
            show();
        };

        function show() {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-id-preview");
                preview.src = src;
                preview.style.display = "block";
                document.getElementById("file-id-preview").style.visibility = "visible";
            }
        }
    </script>
@endpush
