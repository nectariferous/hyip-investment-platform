@extends(template().'layout.master')

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

    <!-- blog details section start --> 
    <section class="sp_pt_120 sp_pb_120">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-8">
            <div class="blog-details-img">
                <img src="{{ getFile('blog', @$data->data->image) }}" height="400px" width="100%" alt="blog">
            </div>
            <div class="blog-details-content mt-4">
                <h3 class="title mb-3">{{ @$data->data->title }}</h3>
                <p class="text-justifys"> <?php echo clean(@$data->data->description); ?></p>

                <div class="social-links my-3">
                    <h5 class="d-inline me-2">{{ __('Share') }}:</h5>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ URL::current() }}" target="_blank"
                        class="social-links-btn btn-border btn-sm ">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.twitter.com/intent/tweet?text=blog;url={{ URL::current() }}" target="_blank" class="social-links-btn btn-border btn-sm"><i class="bx bxl-twitter"></i></a>
                </div>

                <div class="mt-5">
                    <h4>{{ __('All Comments') }}</h4>
                    <hr>
                    @forelse ($comments as $comment)
                        <div class="single-comment">
                            <div class="comment-thumb">
                                @if ($comment->user->image)
                                    <img src="{{ getFile('user', $comment->user->image) }}" alt="pp">
                                @else
                                    <img src="{{ asset('asset/frontend/img/user.png') }}" alt="pp">
                                @endif
                            </div>
                            <div class="comment-content">
                                <h5>{{ $comment->user->fname }} {{ $comment->user->lname }}</h5>
                                <p>{{ $comment->created_at->format('d M Y') }}</p>

                                <p class="mt-2">{{ $comment->comment }}</p>
                            </div>
                        </div>
                    @empty
                        <p>{{ __('Comment Not Found') }}</p>
                    @endforelse

                    {{ $comments->links('backend.partial.paginate') }}
                </div>

                @if (Auth::user())
                    <div class=" mt-5">
                        <div class="site-card">
                            <div class="card-header">
                                <h4>{{ __('Post a Comment') }}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('blogcomment', @$data->id) }}" method="post" role="form">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea class="form-control" name="comment" rows="5" placeholder="Comment" required></textarea>
                                    </div>
                                    <button class="btn main-btn" type="submit">{{ __('Post Comemnt') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
          </div>
          <div class="col-lg-4 ps-lg-4">
            <div class="blog-widget">
              <h4 class="blog-widget-title">{{ __('Recent Blog Posts') }}</h4>
              <div class="short-post-wrapper">
                @forelse ($recentblog as $item)
                    <div class="short-post">
                        <div class="thumb">
                            <img src="{{ getFile('blog', @$item->data->image) }}" alt="image">
                        </div>
                        <div class="content">
                            <h5 class="title"><a href="{{ route('blog', [@$item->id, Str::slug(@$item->data->title)]) }}">{{ @$item->data->title }}</a></h5>
                            <!-- <ul class="blog-meta mt-1">
                                <li><i class="far fa-clock"></i> 29 Mar, 2022</li>
                            </ul> -->
                        </div>
                    </div>
                @empty
                @endforelse
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> 
    <!-- blog details section end --> 
@endsection