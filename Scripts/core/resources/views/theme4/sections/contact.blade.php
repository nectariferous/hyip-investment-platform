@php
$content = content('contact.content');
@endphp

<section class="sp_pt_100 sp_pb_100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <div class="sp_site_header">
                    <h2 class="sp_site_title">{{ __(@$content->data->title) }}</h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="{{ route('contact') }}" method="post" role="form" class="php ">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name"
                                required>
                        </div>
                        <div class="col-md-6 form-group mt-3 mt-md-0">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your Email"
                                required>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject"
                            required>
                    </div>
                    <div class="form-group mt-3">
                        <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                    </div>

                    <div class="mt-3">
                        <button class="btn main-btn w-100" type="submit"><span>{{ __('Send Message') }}</span></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row gy-4 justify-content-center mt-5">
            <div class="col-md-4">
                <div class="contact-item">
                    <div class="icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="content">
                        <h5 class="title">{{ __('Chat to support') }}</h5>
                        <p class="caption">{{ __('Speak to our friendly team') }}</p>
                        <p class="mt-2"><a href="mailto:{{ __(@$content->data->email) }}">{{ __(@$content->data->email) }}</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-item">
                    <div class="icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="content">
                        <h5 class="title">{{ __('Visit us') }}</h5>
                        <p class="caption">{{ __('Visit our office HQ') }}</p>
                        <p class="mt-2">{{ __(@$content->data->location) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-item">
                    <div class="icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="content">
                        <h5 class="title">{{ __('Call us') }}</h5>
                        <p class="caption">{{ __('Mon-Fri from 9am to 5pm') }}</p>
                        <p class="mt-2"><a href="tel:{{ __(@$content->data->phone) }}">{{ __(@$content->data->phone) }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- End Contact Section -->

<div class="map-area">
    <iframe class="map" src="{{ @$general->map_link }}" frameborder="0" allowfullscreen></iframe>
</div>