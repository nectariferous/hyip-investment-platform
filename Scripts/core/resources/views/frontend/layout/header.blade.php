<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-lg-between">

        <div class="logo me-auto me-lg-0"><a href="{{ route('home') }}">
                <span>

                    @if (@$general->logo)
                        <img class="img-fluid rounded sm-device-img text-align"
                            src="{{ getFile('logo', @$general->logo) }}" width="100%" alt="pp">
                    @else
                        {{ __('No Logo Found') }}
                    @endif

                </span>
            </a>
        </div>
        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li><a class="nav-link" href="{{ route('investmentplan') }}">{{ __('Investment Plans') }}</a>
                </li>

                @forelse ($pages as $page)
                    <li><a class="nav-link" href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a>
                    </li>
                @empty
                @endforelse
                <li><a class="nav-link" href="{{ route('allblog') }}">{{ __('Blog') }}</a></li>

                {{-- login for small device --}}

                <li class="d-md-block d-lg-none d-block ">
                    @if (Auth::user())
                        <a class="nav-link" href="{{ route('user.dashboard') }}">{{ __('Dashboard') }}</a>
                    @else
                        <a class="nav-link" href="{{ route('user.login') }}">{{ __('Login') }}</a>
                    @endif
                </li>


                <li class=" d-sm-block d-md-block d-lg-none">
                    <select class="custom-select-form selectric ms-3 rounded changeLang nav-link scrollto"
                        aria-label="Default select example">
                        @foreach ($language_top as $top)
                            <option value="{{ $top->short_code }}"
                                {{ session('locale') == $top->short_code ? 'selected' : '' }}>
                                {{ __(ucwords($top->name)) }}
                            </option>
                        @endforeach
                    </select>
                </li>

                {{-- end login for small device --}}

            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <div class="header-right d-flex d-none  d-md-none d-lg-block">
            @if (Auth::user())
                <a href="{{ route('user.dashboard') }}" class="sp_btn_border sp_btn_sm me-3">{{ __('Dashboard') }}</a>
            @else
                <a href="{{ route('user.login') }}" class="sp_btn_border sp_btn_sm me-3">{{ __('Login') }}</a>
            @endif
            <select class="changeLang" aria-label="Default select example">
                @foreach ($language_top as $top)
                    <option value="{{ $top->short_code }}"
                        {{ session('locale') == $top->short_code ? 'selected' : '' }}>
                        {{ __(ucwords($top->name)) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</header>
