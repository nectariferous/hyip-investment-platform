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
                            <form action="" method="post">

                                @csrf

                                <div class="row">


                                    <div class="form-group col-md-6">

                                        <label for="">{{ __('Allow Cookie Modal') }}</label>

                                        <select name="allow_modal" class="form-control">

                                            <option value="1" {{ @$cookie->allow_modal==1 ? 'selected' : '' }}>
                                                {{ __('Yes') }}</option>
                                            <option value="0" {{ @$cookie->allow_modal==0 ? 'selected' : '' }}>
                                                {{ __('No') }}</option>

                                        </select>

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="">{{ __('Cookie Button Text') }}</label>

                                        <input type="text" name="button_text" class="form-control" placeholder="Cookie Button Text"
                                            value="{{ @$cookie->button_text }}">

                                    </div>

                                    <div class="form-group col-md-12">

                                        <label for="">{{ __('Cookie Text') }}</label>

                                        <textarea name="cookie_text" cols="30" rows="10"
                                            class="form-control">{{ __(clean(@$cookie->cookie_text)) }}</textarea>

                                    </div>

                                    <div class="form-group col-md-12">


                                        <button type="submit" class="btn btn-primary float-right">{{ __('Update Cookie Consent') }}</button>

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
