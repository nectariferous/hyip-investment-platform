@extends(template().'layout.master')

@section('content')
    <section class="breadcrumbs" style="background-image: url({{ getFile('breadcrumbs', @$general->breadcrumbs) }});">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center text-capitalize">
                <h2>{{ __($pageTitle) }}</h2>
                <ol>
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li>{{ __($pageTitle) }}</li>
                </ol>
            </div>

        </div>
    </section>

    <!-- ======= Portfolio Section ======= -->
    <section class="s-pt-100 s-pb-100">
        <div class="container">

            <div class="col-md-12">
                <div class="row ">
                    <div class="col-md-12">
                        <div class="card bg-second">
                            <div class="invest-top">
                                <h4 class="text-center"><b>{{ @$data->data->title }}</b></h4>
                            </div>
                            <div class="p-3">
                                <p class="text-justifys"> <?= clean(@$data->data->description) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section><!-- End Portfolio Section -->
@endsection
