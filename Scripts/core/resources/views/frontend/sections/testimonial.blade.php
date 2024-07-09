@php
$content = content('testimonial.content');
$elements = element('testimonial.element');

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

        <div class="testimonial-slider">
            @forelse ($elements as $element)
                <div class="single-slide">
                    <div class="testimonial-box">
                        <div class="content">
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                {{ @$element->data->answer }}
                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>
                        </div>
                        <div class="client">
                            <div class="thumb">
                                <img src="{{ getFile('testimonial', @$element->data->image) }}"
                                    class="testimonial-img" alt="">
                            </div>
                            <h3 class="title">{{ @$element->data->client_name }}</h3>
                            <span class="designation">{{ @$element->data->designation }}</span>
                        </div>

                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
</section>
