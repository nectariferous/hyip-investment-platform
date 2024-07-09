@php
    $contact = content('contact.content');
    $footersociallink = element('footer.element');
@endphp

<!-- header-section start  -->
<header class="header">
  <div class="header-top">
    <div class="container">
      <div class="row align-items-center gy-2">
        <div class="col-lg-8 col-md-7">
          <ul class="header-top-info-list">
            <li>
              <a href="tel:{{@$contact->data->phone}}"><i class="fas fa-phone"></i> {{@$contact->data->phone}}</a>
            </li>
            <li>
              <a href="mailto:{{@$contact->data->email}}"><i class="fas fa-envelope"></i> {{@$contact->data->email}}</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-4 col-md-5">
          <div class="d-flex flex-wrap align-items-center justify-content-md-end justify-content-center">
              <ul class="social-list me-3">
                @forelse ($footersociallink as $item)
                    <li>
                        <a href="{{ __(@$item->data->social_link) }}" target="_blank"><i class="{{ @$item->data->social_icon }}"></i></a>
                    </li>
                @empty
                @endforelse
              </ul>
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
      </div>
    </div>
  </div>

  <div class="header-bottom"> 
    <div class="container">
      <nav class="navbar navbar-expand-xl p-0 align-items-center">
        <a class="site-logo site-title" href="{{ route('home') }}">
            <img class="img-fluid rounded sm-device-img text-align" src="{{ getFile('logo', @$general->logo) }}" width="100%" alt="pp">
        </a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="menu-toggle"></span>
        </button>
        <div class="collapse navbar-collapse mt-lg-0 mt-3" id="mainNavbar">
          <ul class="nav navbar-nav main-menu ms-auto">
            <li class="nav-item"><a href="#banner" class="nav-link active">{{__('Home')}}</a></li>
            <li class="nav-item"><a href="#about" class="nav-link">{{__('About')}}</a></li>
            <li class="nav-item"><a href="#why-choose" class="nav-link">{{__('Why Choose')}}</a></li>
            <li class="nav-item"><a href="#investment" class="nav-link">{{__('Plan')}}</a></li>
            <li class="nav-item"><a href="#how-start" class="nav-link">{{__('How Work')}}</a></li>
            <li class="nav-item"><a href="#faq" class="nav-link">{{__('Faq')}}</a></li>
            <li class="nav-item"><a href="#testimonial" class="nav-link">{{__('Testimonial')}}</a></li>
            <li class="account-btn">
              @if (Auth::user())
                  <a href="{{ route('user.dashboard') }}" class="nav-link">{{ __('Dashboard') }}</a>
              @else
                  <a href="{{ route('user.login') }}" class="nav-link">{{ __('Login') }}</a>
              @endif
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div><!-- header__bottom end --> 
</header>
<!-- header-section end  -->