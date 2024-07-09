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

                                        <label for="">{{ __('Recaptcha Key') }}</label>

                                        <input type="text" name="recaptcha_key" class="form-control" placeholder="Recaptcha Key"
                                            value="{{ @$recaptcha->recaptcha_key }}">

                                            

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="">{{ __('Recaptcha Secret') }}</label>
                                        <input type="text" name="recaptcha_secret" class="form-control" placeholder="Recaptcha Secret"
                                            value="{{ @$recaptcha->recaptcha_secret }}">

                                    </div>


                                    <div class="form-group col-md-6">

                                        <label for="">{{ __('Allow Recaptcha') }}</label>

                                        <select name="allow_recaptcha" id="" class="form-control selectric">

                                            <option value="1" {{ @$recaptcha->allow_recaptcha==1 ? 'selected' : '' }}>
                                                {{ __('Yes') }}</option>
                                            <option value="0" {{ @$recaptcha->allow_recaptcha==0 ? 'selected' : '' }}>
                                                {{ __('No') }}</option>

                                        </select>

                                    </div>

                                    <div class="form-group col-md-12">


                                        <button type="submit" class="btn btn-primary float-right">{{ __('Update Recaptcha') }}</button>

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
