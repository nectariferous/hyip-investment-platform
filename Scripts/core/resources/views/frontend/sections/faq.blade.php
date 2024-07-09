@php
$content = content('faq.content');
$elements = element('faq.element');
@endphp

<section class="s-pt-100 s-pb-100 dark-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="site-header">
                    <h2 class="site-title">{{ @$content->data->title }}</h2>
                </div>
            </div>
        </div>

        <div class="row g-3">
            @foreach ($elements as $item)
                <div class="col-md-6">
                    <div class="accordion" id="accordionExample">

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-{{$loop->iteration}}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="false"
                                    aria-controls="collapseSix">
                                    {{ @$item->data->question }}
                                </button>
                            </h2>
                            <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse"
                                aria-labelledby="heading-{{$loop->iteration}}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p> {{ @$item->data->answer }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
