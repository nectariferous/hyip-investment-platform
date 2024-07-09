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

                                    <div class="form-group col-md-12">

                                        <label for="">{{ __('Seo Description') }}</label>

                                        <textarea name="seo_description" id="" cols="30" rows="10"
                                            class="form-control">{{ __(clean(@$general->seo_description)) }}</textarea>

                                    </div>


                                    <div class="form-group col-md-12">


                                        <button type="submit" class="btn btn-primary float-right">{{ __('Update Seo') }}</button>

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
