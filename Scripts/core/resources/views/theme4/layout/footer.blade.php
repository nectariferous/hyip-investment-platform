@php
$content = content('contact.content');
$contentlink = content('footer.content');
$footersociallink = element('footer.element');
$serviceElements = element('service.element');

@endphp

<footer class="footer-section has-bg-img">
    <div class="footer-logo-portion">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <a href="{{ route('home') }}" class="footer-logo">
                        @if (@$general->logo)
                            <img class="img-fluid rounded sm-device-img text-align"
                                src="{{ getFile('logo', @$general->whitelogo) }}" width="100%" alt="pp">
                        @else
                            {{ __('No Logo Found') }}
                        @endif
                    </a>

                    <ul class="social-links justify-content-center mt-3">
                        @forelse ($footersociallink as $item)
                            <li>
                                <a href="{{ __(@$item->data->social_link) }}" target="_blank"
                                    class="twitter"><i class="{{ @$item->data->social_icon }}"></i></a>
                            </li>
                        @empty
                        @endforelse
                    </ul>

                    <ul class="footer-inline-list justify-content-center mt-4">
                        <li> <a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        @forelse ($pages as $page)
                            <li><a href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a></li>
                        @empty
                        @endforelse
                    </ul>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="footer-menu-portion">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="mb-0 footer-text-clr">
                        @if (@$general->copyright)
                            {{ __(@$general->copyright) }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>