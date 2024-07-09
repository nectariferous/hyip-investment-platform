@php
$content = content('blog.content');
$blogs = element('blog.element')->take(2);
@endphp

<section class="blog-section sp_pt_120 sp_pb_120">
    <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-7 text-center">
            <div class="sp_site_header  wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
              <h2 class="sp_site_title">{{ __(@$content->data->title) }}</h2>
            </div>
          </div>
        </div>
        <div class="row gy-4">
            @foreach ($blogs as $blog)
                @php
                    $comment = App\Models\Comment::where('blog_id', $blog->id)->count();
                @endphp
                <div class="col-md-6 col-lg-6">
                    <div class="blog-item blog-list-style">
                        <div class="blog-thumb">
                            <img src="{{ getFile('blog', @$blog->data->image) }}" alt="blog thumb">
                        </div>
                        <div class="blog-content">
                            <h4 class="blog-title mt-0"><a href="{{ route('blog', [@$blog->id, Str::slug(@$blog->data->title)]) }}">{{ @$blog->data->title }}</a></h4>
                            <ul class="blog-meta mt-2">
                                <li><i class="fas fa-clock"></i> {{ @$blog->created_at->diffforhumans() }}</li>
                                <li><i class="fas fa-comment"></i> {{ $comment }} {{ __('comments') }}</li>
                            </ul>

                            <p class="mt-3">{{ @$blog->data->short_description }}</p>
                            
                            <a href="{{ route('blog', [@$blog->id, Str::slug(@$blog->data->title)]) }}" class="blog-btn">
                                <span>{{ __('Read More') }}</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
