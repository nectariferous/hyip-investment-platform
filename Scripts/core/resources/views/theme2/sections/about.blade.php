   @php
       $content = content('about.content');
   @endphp

<section id="about" class="about-section s-pt-100 s-pb-100 separator-bg">
    <div class="about-globe">
        <img src="{{ getFile('bg','globe3.png')}}" alt="image">
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 d-lg-block d-none">
                <div class="about-thumb">
                    <img src="{{ getFile('about', @$content->data->image) }}" alt="image">
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="sp_site_title">{{ __(@$content->data->title) }}</h2>
                <p class="text-white text-justifys descripton-root">
                    <?php
                    echo clean(@$content->data->description);
                    ?>
                </p>
                <a href="{{ __(@$content->data->button_text_link) }}" class="sp_theme_btn">{{ __(@$content->data->button_text) }}</a>
            </div>
        </div>
    </div>
</section>