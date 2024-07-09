@php
$content = content('howitwork.content');
$elements = element('howitwork.element')->take(8);
@endphp

    <section class="work-section sp_pt_120 sp_pb_120" style="background-image: url('{{ asset('asset/theme3/images/bg/bg7.jpg') }}')">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-7 text-center">
            <div class="sp_site_header  wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
              <h2 class="sp_site_title">{{ __(@$content->data->title) }}</h2>
            </div>
          </div>
        </div>

        <div class="row gy-4 justify-content-center">
          @foreach ($elements as $element)
          <div class="col-lg-4 col-md-6">
              <div class="work-item">
                  <div class="work-number">
                      {{ $loop->iteration }}
                  </div>
                  <div class="work-content">
                      <h4 class="title">{{ __(@$element->data->title) }}</h4>
                      <p class="mt-2"><?= clean($element->data->short_description) ?></p>
                  </div>
              </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>