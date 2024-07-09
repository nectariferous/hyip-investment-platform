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
                            <a href="{{ route('admin.admins.index') }}" class="btn btn-primary"> <i
                                    class="fa fa-arrow-left"></i>
                                {{ __('Go Back') }}</a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.admins.update', $admin) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">

                                    <div class="form-group col-md-3">
                                        <label class="col-form-label">{{__('Admin Image')}}</label>
        
                                        <div id="image-preview" class="image-preview"
                                            style="background-image:url({{ getFile('admins' ,$admin->image) }});">
                                            <label for="image-upload" id="image-label">{{__('Choose File')}}</label>
                                            <input type="file" name="admin_image" id="image-upload" />
                                        </div>
        
                                    </div>

                                    <div class="col-md-9"></div>
                                   

                                    <div class="form-group col-md-6">
                                        <label for="">{{__('Full Name')}}</label>
                                        <input type="text" name="name" class="form-control" required value="{{$admin->name}}">
                                    </div>
    
    
                                    <div class="form-group col-md-6">
                                        <label for="">{{__('Username')}}</label>
                                        <input type="text" name="username" class="form-control" required value="{{$admin->username}}">
                                    </div>
    
    
                                    
                                    <div class="form-group col-md-6">
                                        <label for="">{{__('Email')}}</label>
                                        <input type="email" name="email" class="form-control" required value="{{$admin->email}}">
                                    </div>
    
    
                                    <div class="form-group col-md-6">
                                        <label for="">{{__('Password')}}</label>
                                        <input type="password" name="password" class="form-control" >
                                    </div>
    
                                    <div class="form-group col-md-6">
                                        <label for="">{{__('Password Confirmation')}}</label>
                                        <input type="password" name="password_confirmation" class="form-control" >
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="">{{__('Roles')}}</label>
                                        <select name="roles[]" class="form-control js-example-tokenizer" multiple>
                                            @foreach ($roles as $role)
                                             <option value="{{$role->name}}" {{$admin->hasRole($role->name) ? 'selected' : ''}}>{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>


                                    <button class="btn btn-primary" type="admin">{{__('Update Admin')}}</button>

                                </div>

                            </form>
                        </div>

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
                placeholder: "Select Role"
            })

            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "{{__('Choose File')}}", // Default: Choose File
                label_selected: "{{__('Update Image')}}", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });

        })
    </script>
@endpush