@extends(template().'layout.master')

@section('content')
    <section class="page-banner">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <h2 class="title text-white">{{__($pageTitle)}}</h2>
                    <ul class="page-breadcrumb justify-content-center mt-2">
                        <li><a href="{{route('home')}}">{{__('Home')}}</a></li>
                        <li>{{__($pageTitle)}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ======= Portfolio Section ======= -->
    <section class="sp_pt_100 sp_pb_100">
        <div class="container">
            <div class="col-md-12">
                <div class="row ">
                    <div class="col-md-12">
                        <div class="site-card">
                            <div class="card-body">
                                <h4 class="text-center mb-4"><b>{{ @$data->data->title }}</b></h4>
                                <p class="text-justifys"> <?= clean(@$data->data->description) ?></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section><!-- End Portfolio Section -->
@endsection
