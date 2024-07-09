<!-- @php
$content = content('feature.content');
$elements = element('feature.element')->take(6);
@endphp

<section class="s-pt-100 s-pb-100">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="sp_site_header">
                    <h2 class="sp_site_title">{{ __(@$content->data->title) }}</h2>
                </div>
            </div>
        </div>

        <div class="row gy-4 feature-wrapper">
            @foreach ($elements as $element)
                <div class="col-lg-4 col-md-6">
                    <div class="feature-box">
                        <div class="icon">
                            <div class="icon-line">
                                <span class="icon-line-dot icon-line-dot-one"></span>
                                <span class="icon-line-dot icon-line-dot-two"></span>
                                <span class="icon-line-dot icon-line-dot-three"></span>
                            </div>
                            <div class="icon-inner">

                                <i class="{{ @$element->data->card_icon }}"></i>
                            </div>
                        </div>
                        <div class="content">
                            <h3 class="title mb-3">{{ __(@$element->data->card_title) }}</h3>
                            <p class="mb-0">{{ __(@$element->data->card_description) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section> -->



@php
$content = content('feature.content');
$elements = element('feature.element')->take(6);
@endphp

<!-- why choose section start -->
<section id="why-choose" class="choose-section s-pt-100 s-pb-100">
    <div class="choose-el">
        <img src="{{ getFile('bg','choose-el.png') }}" alt="image">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
            <div class="sp_site_header text-center">
                <h2 class="sp_site_title">{{ __(@$content->data->title) }}</h2>
            </div>
            </div>
        </div><!-- row end -->
        <div class="choose-wrapper">

            <div class="choose-wrapper-thumb">
                <div class="thumb-inner">
                    <i class="fab fa-btc"></i>
                </div>
                <div class="left-1"></div>
                <div class="left-2"></div>
                <div class="right-1"></div>
                <div class="right-2"></div>
            </div>

            <div class="choose-wrapper-inner">
                @foreach ($elements as $element)
                    <div class="choose-item  wow fadeInLeft" data-wow-delay="0.3s" data-wow-duration="0.5s">
                        <div class="icon">
                            <i class="{{ @$element->data->card_icon }}"></i>
                        </div>
                        <div class="content">
                            <h4 class="title">{{ __(@$element->data->card_title) }}</h4>
                            <p class="mt-2 mb-0">{{ __(@$element->data->card_description) }}</p>
                        </div>
                    </div><!-- choose-item end -->
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- why choose section end -->