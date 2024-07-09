@php
$content = content('howitwork.content');
$elements = element('howitwork.element')->take(8);
@endphp

<section id="how-start" class="s-pt-100 s-pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="sp_site_header">
                    <h2 class="sp_site_title">{{ __(@$content->data->title) }}</h2>
                </div>
            </div>
        </div>

        <div class="row gy-5 work-wrapper">
            @foreach ($elements as $element)
                <div class="col-lg-4">
                    <div class="work-box">
                        <div class="icon">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="content">
                            <h3 class="title">{{ __(@$element->data->title) }}</h3>
                            <p><?= clean($element->data->short_description) ?></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
