@extends(template().'layout.master')

@section('content')
    <!-- ======= Breadcrumbs ======= -->
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
    <!-- End Breadcrumbs -->

    @if ($page->sections != null)
        @foreach ($page->sections as $sections)
            @include('frontend.sections.' . $sections)
        @endforeach
    @endif



@endsection
