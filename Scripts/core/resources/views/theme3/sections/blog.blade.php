@php
$content = content('blog.content');
$blogs = element('blog.element')->take(6);
@endphp

<section class="blog-section sp_pt_120 sp_pb_120 sp_separator_bg" style="background-image: url('{{ asset('asset/theme3/images/bg/bg6.jpg') }}')">
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
    </div>
</section>
