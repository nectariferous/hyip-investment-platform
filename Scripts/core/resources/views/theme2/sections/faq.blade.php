@php
$content = content('faq.content');
$elements = element('faq.element');
@endphp

<!-- faq section start -->
<section id="faq" class="faq-section separator-bg s-pt-100 s-pb-100">
      <div class="faq-el">
        <img src="{{ getFile('faq', 'faq.png') }}" alt="image">
      </div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="sp_site_header text-center">
              <h2 class="sp_site_title">{{ @$content->data->title }}</h2>
            </div>
          </div>
        </div><!-- row end -->
        <div class="row">
          <div class="col-lg-12">
            <div class="faq-wrapper wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="0.5s">
                @foreach ($elements as $item)
                <div class="faq-single">
                    <div class="faq-single-header">
                    <h4 class="title">{{ @$item->data->question }}</h4>
                    </div>
                    <div class="faq-single-body">
                    <p>{{ @$item->data->answer }}</p>
                    </div>
                </div><!-- faq-single end -->
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- faq section end -->