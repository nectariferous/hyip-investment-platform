@extends(template().'layout.master2')
@push('style')
    <style>
        .image-preview input,
        #callback-preview input {
            position: absolute;
            left: 0px;
            top: 0px;
            z-index: -1;
        }

        .image-preview label,
        #callback-preview label {
            background-color: #47494b;
            text-align: center;
            padding: 10px;
            width: 100%;
            cursor: pointer;
        }

        .image-preview {
            background: center;
            background-repeat: no-repeat;
            background-size: cover;
            width: 50%;
            height: 150px;
        }

        .image-preview,
        #callback-preview {
            width: 100%;
            height: 250px;
            border: 2px solid #212529;
            border-radius: 3px;
            position: relative;
            overflow: hidden;
            background-color: #212529;
        }

    </style>
@endpush
@section('content2')
<section class="breadcrumbs" style="background-image: url({{ getFile('breadcrumbs', @$general->breadcrumbs) }});">
    <div class="container">
            <div class="d-flex justify-content-between align-items-center text-capitalize">
                <h2>{{ __($pageTitle) }}</h2>
                <ol>
                    <li><a href="{{ route('user.dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li>{{ __($pageTitle) }}</li>
                </ol>
            </div>

        </div>
    </section>
    <section>
        <div class="container">
            <div class="body-adjust">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="project-status-top d-flex justify-content-end">
                                <h4 class="project-status-heading">
                                    <a href="{{ route('user.ticket.index') }}"><button class="btn btn-main mt-2">
                                            <i class="fas fa-arrow-left"> {{ __('Back to List') }}</i>
                                        </button>
                                    </a>
                                </h4>
                            </div>
                            <div class="card card-wrapper">
                                <form action="{{ route('user.ticket.store') }}" enctype="multipart/form-data" class="p-3"
                                    method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-2">{{ __('Subject') }}</label>
                                                <input type="text" name="subject" class="form-control bg-dark" required=""
                                                    placeholder="{{ __('subject here') }}"
                                                    value="{{ old('subject') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="mb-2">{{ __('Priority') }}</label>
                                                    <select class="form-select selectric bg-dark"  name="priority" aria-label="Default select example">
                                                    <option value="1">{{ __('High') }}</option>
                                                    <option value="2">{{ __('Medium') }}</option>
                                                    <option value="3">{{ __('Low') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-lg-6 mt-3">
                                            <div class="form-group ticket-comment-box">
                                                <label class="mb-2" for="exampleFormControlTextarea1">{{ __('Message') }}</label>
                                                <textarea class="form-control bg-dark" id="exampleFormControlTextarea1" rows="6"
                                                    name="message" placeholder="Massage">{{ old('message') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <div id="image-preview" class="image-preview">
                                                <label class="mb-2" for="image-upload" id="image-label">{{ __('Choose File') }}</label>
                                                <input type="file" class="form-control bg-dark" name="file" id="image-upload" />
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-lg-12 text-center">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-main mt-3">{{ __('Send') }}</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

            </div>
        </div>
    </section>
@endsection
@push('script')

    <script>
        $(function(){
            'use strict'

            $.uploadPreview({
                input_field: "#image-upload",
                preview_box: "#image-preview",
                label_default: "{{__('Choose File')}}",
                label_selected: "{{__('Update Image')}}",
                no_label: false,
                success_callback: null
            });
        })
    </script>

@endpush
