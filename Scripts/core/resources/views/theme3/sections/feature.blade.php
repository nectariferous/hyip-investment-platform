@php
$content = content('feature.content');
[$elements, $elements2] = element('feature.element')->chunk(3);


@endphp
    <section class="benefit-section sp_pt_120 sp_pb_120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="sp_site_header  wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                        <h2 class="sp_site_title">{{ __(@$content->data->title) }}</h2>
                    </div>
                </div>
            </div>
            <div class="row gy-4 align-items-center">
                <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.7s">

                    @foreach ($elements as $element)
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <div class="benefit-icon-inner">
                                <i class="{{ @$element->data->card_icon }}"></i>
                            </div>
                        </div>
                        <div class="benefit-content">
                            <h4 class="title">{{ __(@$element->data->card_title) }}</h4>
                            <p class="mt-2">{{ __(@$element->data->card_description) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-lg-4 d-xl-block d-none">
                    <div class="benefit-thumb paroller"
                        data-paroller-factor="0.2" 
                        data-paroller-factor-xs="0.0"
                        data-paroller-factor-sm="0.0"
                        data-paroller-factor-md="0.0"
                        data-paroller-factor-md="0.0"
                        data-paroller-factor-lg="0.0"
                        data-paroller-type="foreground" 
                        data-paroller-direction="vertical"
                    >
                        <img src="{{ asset('asset/theme3/images/benefit3.png') }}" alt="image">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.9s">

                    @foreach ($elements2 as $element)
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <div class="benefit-icon-inner">
                                <i class="{{ @$element->data->card_icon }}"></i>
                            </div>
                        </div>
                        <div class="benefit-content">
                            <h4 class="title">{{ __(@$element->data->card_title) }}</h4>
                            <p class="mt-2">{{ __(@$element->data->card_description) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>