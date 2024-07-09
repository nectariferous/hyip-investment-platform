@php
$content = content('testimonial.content');
$elements = element('testimonial.element');

@endphp

<!-- testimonial section start -->
<section id="testimonial" class="testimonial-section s-pt-100 s-pb-100 separator-bg">
    <div class="testimoinal-el">
    <img src="{{ getFile('bg', 'globe2.png') }}" alt="image">
    </div>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
        <div class="sp_site_header text-center">
            <h2 class="sp_site_title">{{ __(@$content->data->title) }}</h2>
            <p>{{ __(@$content->data->sub_title) }}</p>
        </div>
        </div>
    </div><!-- row end -->
    <div class="testimonial-slider wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="0.5s">
        @forelse ($elements as $element)
            <div class="single-slide">
                <div class="testimonial-item">
                <div class="ratings mb-2">
                    <i class="las la-star"></i>
                    <i class="las la-star"></i>
                    <i class="las la-star"></i>
                    <i class="las la-star"></i>
                    <i class="las la-star"></i>
                </div>
                <p class="mb-4">{{ @$element->data->answer }}</p>
                <hr>
                <div class="testimonial-client mt-4">
                    <div class="thumb">
                    <img src="{{ getFile('testimonial', @$element->data->image) }}" alt="image">
                    </div>
                    <div class="content">
                        <h5 class="name p-0 mb-0">{{ @$element->data->client_name }}</h5>
                        <span>{{ @$element->data->designation }}</span>
                    </div>
                </div>
                </div>
            </div><!-- single-slide end -->
        @empty
        @endforelse
    </div>
    </div>
</section>
<!-- testimonial section end -->