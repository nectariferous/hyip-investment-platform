@php
$content = content('faq.content');
$elements = element('faq.element');
@endphp

<section class="faq-section sp_pt_120 sp_pb_120 sp_separator_bg" style="background-image: url('{{ asset('asset/theme3/images/bg/bg3.jpg') }}')">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="sp_site_header">
                    <h2 class="sp_site_title">{{ @$content->data->title }}</h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center g-3">
            <div class="col-md-10">
                <div class="accordion" id="accordionExample">
                    @foreach ($elements as $item)
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
