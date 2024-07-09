@extends(template().'layout.master')
@push('name')
    <style>
        .card-footer {
            padding: 0.5rem, 0rem !important;
        }

    </style>
@endpush
@section('content')
    <section class="page-banner">
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h2 class="title text-white">{{ __($pageTitle) }}</h2>
                <ul class="page-breadcrumb justify-content-center mt-2">
                    <li><a href="index.html">{{ __('Home') }}</a></li>
                    <li>{{ __($pageTitle) }}</li>
                </ul>
            </div>
            </div>
        </div>
    </section>

    <section class="blog-section sp_pt_100 sp_pb_100">
        <div class="container">
            <div class="row gy-4">
                @foreach ($blogs as $blog)
                    @php
                        $comment = App\Models\Comment::where('blog_id', $blog->id)->count();
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-item">
                            <div class="blog-thumb">
                                <img src="{{ getFile('blog', @$blog->data->image) }}" alt="blog thumb">
                            </div>
                            <div class="blog-content">
                                <ul class="blog-meta mb-2">
                                    <li><i class="fas fa-clock"></i> {{ @$blog->created_at->diffforhumans() }}</li>
                                    <li><i class="fas fa-comment"></i> {{ $comment }} {{ __('comments') }}</li>
                                </ul>
                                <h4 class="blog-title"><a href="{{ route('blog', [@$blog->id, Str::slug(@$blog->data->title)]) }}">{{ @$blog->data->title }}</a></h4>
                                <a href="{{ route('blog', [@$blog->id, Str::slug(@$blog->data->title)]) }}" class="blog-btn">
                                    <span>{{ __('Read More') }}</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $blogs->links('backend.partial.paginate') }}
        </div>
    </section>
@endsection
