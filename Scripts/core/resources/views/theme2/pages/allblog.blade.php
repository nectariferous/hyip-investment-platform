@extends(template().'layout.master')
@push('name')
    <style>
        .card-footer {
            padding: 0.5rem, 0rem !important;
        }

    </style>
@endpush
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



    <section class="s-pt-100 s-pb-100">
        <div class="container">
            <div class="row gy-4">
                @foreach ($blogs as $blog)
                    @php
                        $comment = App\Models\Comment::where('blog_id', $blog->id)->count();
                    @endphp

                    <div class="col-md-6 col-lg-4">
                        <div class="blog-box">
                            <div class="blog-box-thumb">
                                <img src="{{ getFile('blog', @$blog->data->image) }}" alt="image">
                            </div>
                            <div class="blog-box-content">
                                <span class="blog-category">{{ @$blog->data->tag }}</span>
                                <h3 class="title"><a
                                        href="{{ route('blog', [@$blog->id, Str::slug(@$blog->data->title)]) }}">{{ @$blog->data->title }}</a>
                                </h3>
                                <ul class="blog-meta">
                                    <li><i class="fas fa-clock"></i> {{ @$blog->created_at->diffforhumans() }}</li>
                                    <li><i class="fas fa-comment"></i> {{ $comment }} {{ __('comments') }}</li>
                                </ul>
                                <p class="mb-0 mt-3">{{ @$blog->data->short_description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $blogs->links('backend.partial.paginate') }}
        </div>
    </section>
@endsection
