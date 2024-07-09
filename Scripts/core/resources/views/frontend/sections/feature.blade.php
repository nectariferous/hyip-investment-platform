@php
$content = content('feature.content');
$elements = element('feature.element')->take(6);
@endphp

<section class="s-pt-100 s-pb-100">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="site-header">
                    <h2 class="site-title">{{ __(@$content->data->title) }}</h2>
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
</section><!-- End Services Section -->
