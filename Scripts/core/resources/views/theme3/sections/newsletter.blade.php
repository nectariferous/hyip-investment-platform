@php
$content = content('newsletter.content');
@endphp

<section class="subscribe-section" style="background-image: url('{{ asset('asset/theme3/images/bg/bg9.jpg') }}');">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="sp_site_header">
                    <h2 class="sp_site_title">{{ __(@$content->data->title) }}</h2>
                    <p>{{ __(@$content->data->short_description) }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <form class="subscribe-form" id="subscribe" method="POST">
                    @csrf
                    <input type="text" name="email" class="form-control subscribe-email"
                        placeholder="{{ __('Enter email here') }}">
                    <button>{{ __('Subscribe') }} <i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </div>
</section>
