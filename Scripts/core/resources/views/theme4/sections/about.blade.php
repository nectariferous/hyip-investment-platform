   @php
       $content = content('about.content');
   @endphp


   <!-- about section start -->
   <section class="about-section sp_pt_120 sp_pb_120 overflow-hidden">
      <div class="about-section-el">
        <img src="{{ getFile('elements', 'el-2.png') }}" alt="image">
      </div>
      <div class="container">
        <div class="row gy-5 justify-content-between">
          <div class="col-lg-6 col-md-10">
            <div class="about-thumb">
              <img src="{{ getFile('about', @$content->data->image) }}" alt="image">
            </div>
          </div>
          <div class="col-lg-6 ps-xl-5 p-lg-4 about-content wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
            <div class="about-content">
              <h2 class="sp_site_title">{{ __(@$content->data->title) }}</h2>
              <p class="fs-lg mt-3">
                  <?php
                      echo clean(@$content->data->description);
                  ?>
              </p>
              <a href="{{ __(@$content->data->button_text_link) }}" class="btn main-btn mt-4"><span>{{ __(@$content->data->button_text) }}</span></a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- about section end -->