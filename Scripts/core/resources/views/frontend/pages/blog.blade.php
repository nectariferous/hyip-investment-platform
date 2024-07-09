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
            <div class="row gy-4">
                <div class="col-lg-8">
                    <div class="card bg-second">
                        <img src="{{ getFile('blog', @$data->data->image) }}" height="400px" width="100%" alt="blog">

                        <div class="p-3">
                            <h3 class="mt-3"><b>{{ @$data->data->title }}</b></h3>
                            <p class="text-justifys"> <?php echo clean(@$data->data->description); ?>
                            </p>
                        </div>

                        <div class="social-links my-3 ms-3">
                            <h5 class="d-inline me-2">{{ __('Share') }}:</h5>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ URL::current() }}" target="_blank"
                                class="social-links-btn sp_btn_border sp_btn_sm">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.twitter.com/intent/tweet?text=blog;url={{ URL::current() }}"
                                target="_blank" class="social-links-btn sp_btn_border sp_btn_sm"><i
                                    class="bx bxl-twitter"></i></a>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3>{{ __('All Comments') }}</h3>
                        <hr>

                        @forelse ($comments as $comment)
                            <div class="d-flex justify-content-between">
                                <div class="user-icon">
                                    <div>

                                        @if ($comment->user->image)
                                            <img src="{{ getFile('user', $comment->user->image) }}" alt="pp">
                                        @else
                                            <img src="{{ asset('asset/frontend/img/user.png') }}" alt="pp">
                                        @endif



                                    </div>
                                    <h6>{{ $comment->user->fname }} {{ $comment->user->lname }}</h6>
                                </div>

                                <p>{{ $comment->created_at->format('d M Y') }}</p>
                            </div>
                            <p class="comment text-justifys">{{ $comment->comment }}</p>

                            <hr>
                        @empty
                            <p>{{ __('Comment Not Found') }}</p>
                        @endforelse

                        {{ $comments->links('backend.partial.paginate') }}


                    </div>

                    @if (Auth::user())
                        <div class=" mt-4">
                            <div class="card bg-second">
                                <div class="card-header">
                                    <h5 class="p-3">{{ __('Post a Comment') }}</h5>
                                </div>
                                <form action="{{ route('blogcomment', @$data->id) }}" method="post" role="form"
                                    class="p-3">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea class="form-control" name="comment" rows="5" placeholder="Comment" required></textarea>
                                    </div>

                                    <button class="sp_theme_btn" type="submit">{{ __('Post Comemnt') }}</button>
                                </form>

                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-4 ps-lg-5">
                    <div class="card bg-second">
                        <div class="card-header">
                            <h4 class="mb-0">{{ __('Recent Blogs') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="side-blog-list">
                                @forelse ($recentblog as $item)
                                    <div class="side-blog">
                                        <div class="side-blog-thumb">
                                            <img src="{{ getFile('blog', @$item->data->image) }}" alt="image">
                                        </div>
                                        <div class="side-blog-content">
                                            <h6 class="mb-0"><a
                                                    href="{{ route('blog', [@$item->id, Str::slug(@$item->data->title)]) }}">{{ @$item->data->title }}</a>
                                            </h6>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Portfolio Section -->
@endsection
