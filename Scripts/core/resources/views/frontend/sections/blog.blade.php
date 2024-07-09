@php
$content = content('blog.content');
$blogs = element('blog.element')->take(6);
@endphp

<section class="s-pt-100 s-pb-100 dark-bg">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="site-header">
                    <h2 class="site-title">{{ __(@$content->data->title) }}</h2>
                </div>
            </div>
        </div>
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


    </div>
</section>
