@php
$content = content('contact.content');
$contentlink = content('footer.content');
$footersociallink = element('footer.element');
$serviceElements = element('service.element');

@endphp

<footer class="footer-section cover-image">
    <div class="footer-logo-portion">
        <div class="container">
            <div class="row gy-3 align-items-center">
                <div class="col-lg-5">
                    <ul class="footer-inline-list justify-content-lg-start justify-content-center">
                        <li>
                            <a href="#0"><i class="fas fa-envelope"></i> {{ __(@$content->data->email) }}</a>
                        </li>
                        <li>
                            <a href="#0"><i class="fas fa-phone"></i> {{ __(@$content->data->phone) }}</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-2 text-center">
                    <a href="{{ route('home') }}" class="footer-logo">
                        @if (@$general->logo)
                            <img class="img-fluid rounded sm-device-img text-align"
                                src="{{ getFile('logo', @$general->logo) }}" width="100%" alt="pp">
                        @else
                            {{ __('No Logo Found') }}
                        @endif
                    </a>
                </div>

                <div class="col-lg-5">
                    <ul class="social-links justify-content-lg-end justify-content-center">
                        @forelse ($footersociallink as $item)
                            <li>
                                <a href="{{ __(@$item->data->social_link) }}" target="_blank"
                                    class="twitter"><i class="{{ @$item->data->social_icon }}"></i></a>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-menu-portion">
        <div class="container">
            <div class="row gy-2">
                <div class="col-lg-6">
                    <ul class="footer-inline-list justify-content-lg-start justify-content-center">
                        <li> <a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        @forelse ($pages as $page)
                            <li><a href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a></li>
                        @empty
                        @endforelse
                    </ul>
                </div>
                <div class="col-lg-6 text-lg-end text-center">
                    <p class="mb-0">
                        @if (@$general->copyright)
                            {{ __(@$general->copyright) }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
