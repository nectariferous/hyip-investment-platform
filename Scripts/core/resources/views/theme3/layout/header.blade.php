@php
    $contact = content('contact.content');
    $footersociallink = element('footer.element');
@endphp  
  
  <!-- header-section start  -->
  <header class="header">
    <div class="header-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 header-top-left d-lg-block d-none">
            <ul class="hc-list justify-content-lg-start justify-content-center">
              <li><a href="mailto:{{@$contact->data->email}}"><i class="fas fa-envelope"></i> {{@$contact->data->email}}</a></li>
              <li><a href="tel:{{@$contact->data->phone}}"><i class="fas fa-mobile-alt"></i> {{@$contact->data->phone}}</a></li>
            </ul>
          </div>
          <div class="col-lg-6 header-top-right">
            <ul class="hc-list justify-content-lg-end justify-content-center">
              <li>
                <ul class="social-icons">
                  @forelse ($footersociallink as $item)
                    <li>
                      <a href="{{ __(@$item->data->social_link) }}" target="_blank"><i class="{{ @$item->data->social_icon }}"></i></a>
                    </li>
                  @empty
                  @endforelse
                </ul>
              </li>
              <select class="changeLang" aria-label="Default select example">
                @foreach ($language_top as $top)
                  <option value="{{ $top->short_code }}"
                    {{ session('locale') == $top->short_code ? 'selected' : '' }}>
                    {{ __(ucwords($top->name)) }}
                  </option>
                @endforeach
              </select>
            </ul>
          </div>
        </div>
      </div>
    </div><!-- header-top end -->

    <div class="header-bottom"> 
      <div class="container">
        <nav class="navbar navbar-expand-xl p-0 align-items-center">

            <a class="site-logo site-title" href="{{ route('home') }}">
                @if (@$general->logo)
                    <img class="img-fluid rounded sm-device-img text-align" src="{{ getFile('logo', @$general->logo) }}" width="100%" alt="pp">
                @else
                    {{ __('No Logo Found') }}
                @endif
            </a>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="menu-toggle"></span>
            </button>
            <div class="collapse navbar-collapse mt-lg-0 mt-3" id="mainNavbar">
                <ul class="nav navbar-nav sp_main_menu me-auto">
                    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}"><a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a></li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('investmentplan') }}">{{ __('Investment Plans') }}</a>
                    </li>

                    @forelse ($pages as $page)
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a>
                    </li>
                    @empty 
                    @endforelse 

                    <li class="nav-item"><a class="nav-link" href="{{ route('allblog') }}">{{ __('Blog') }}</a></li>
                    
                </ul>
                <div class="navbar-action">
                    @if (Auth::user())
                        <a class="btn main-btn btn-sm" href="{{ route('user.dashboard') }}">{{ __('Dashboard') }}</a>
                    @else
                        <a class="text-white me-3" href="{{ route('user.login') }}">{{ __('Login') }}</a>
                        <a href="{{route('user.register')}}" class="btn main-btn btn-sm">Sign up <i class="las la-long-arrow-alt-right ms-2"></i></a>
                    @endif
                </div>
            </div>
        </nav>
      </div>
    </div><!-- header-bottom end --> 
  </header>
  <!-- header-section end  -->


{{-- <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-lg-between">
        <div class="logo me-auto me-lg-0">
        </div>
        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
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
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <div class="header-right d-flex d-none  d-md-none d-lg-block">
            @if (Auth::user())
                <a href="{{ route('user.dashboard') }}" class="btn-border btn-sm me-3">{{ __('Dashboard') }}</a>
            @else
                <a href="{{ route('user.login') }}" class="btn-border btn-sm me-3">{{ __('Login') }}</a>
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
</header> --}}