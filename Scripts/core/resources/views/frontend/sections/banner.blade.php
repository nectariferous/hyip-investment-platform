@php
    $content = content('banner.content');
    $counter = element('banner.element');
@endphp

<section class="banner-section cover-image"
    style="background-image: url({{ getFile('banner', @$content->data->backgroundimage) }});">
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-7 col-lg-8 text-lg-start text-center">
                <h2 class="banner-title"> {{ __(@$content->data->title) }}</h2>
                <p>{{ __(@$content->data->short_description) }}</p>
                <div class="banner-btn-group justify-content-lg-start justify-content-center mt-4">
                    <a href="{{ __(@$content->data->button_text_link) }}" class="sp_theme_btn">{{ __(@$content->data->button_text) }}</a>
                    <a href="{{ __($content->data->button_text_2_link) }}" class="sp_border_btn">{{ __($content->data->button_text_2) }}</a>
                </div>
                <h5 class="mt-5">{{ @$content->data->cta_title }}</h5>
                <div class="row mt-4 overview-wrapper">
                    @foreach ($counter as $count)
                        <div class="col-lg-3 col-4">
                            <div class="overview-box">
                                <div class="overview-box-amount">{{ $count->data->total }}</div>
                                <p>{{ $count->data->title }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
    <div class="tradingview-widget-container__widget"></div>
    <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/markets/" rel="noopener"
            target="_blank"><span class="blue-text">Markets today</span></a> by TradingView</div>
    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
        {
            "symbols": [{
                    "proName": "FOREXCOM:SPXUSD",
                    "title": "S&P 500"
                },
                {
                    "proName": "FOREXCOM:NSXUSD",
                    "title": "US 100"
                },
                {
                    "proName": "FX_IDC:EURUSD",
                    "title": "EUR/USD"
                },
                {
                    "proName": "BITSTAMP:BTCUSD",
                    "title": "Bitcoin"
                },
                {
                    "proName": "BITSTAMP:ETHUSD",
                    "title": "Ethereum"
                }
            ],
            "showSymbolLogo": true,
            "colorTheme": "dark",
            "isTransparent": true,
            "displayMode": "adaptive",
            "locale": "en"
        }
    </script>
</div>
<!-- TradingView Widget END -->


<div class="calculate-area">
    <div class="calculator"><img src="{{ getFile('elements', 'budget.png') }}" alt="image"></div>
    <div class="shape-1"><img src="{{ getFile('elements', 'cal-1.png') }}" alt="image"></div>
    <div class="shape-2"><img src="{{ getFile('elements', 'cal-2.png') }}" alt="image"></div>
    <div class="shape-3"><img src="{{ getFile('elements', 'cal-3.png') }}" alt="image"></div>
    <div class="shape-4"><img src="{{ getFile('elements', 'cal-4.png') }}" alt="image"></div>

    <div class="container">
        <div class="row gy-4 align-items-end">
            <div class="col-lg-4 col-md-6">
                <label class="mbl-h">{{ __('Amount') }}</label>
                <input type="text" class="form-control" name="amount" id="amount"
                    placeholder="{{ __('Enter amount') }}">
            </div>
            <div class="col-lg-5 col-md-6">
                <label class="mbl-h">{{ __('Investment Plan') }}</label>
                <select class="form-select" name="selectplan" id="plan">
                    <option selected disabled class="text-secondary">{{ __('Select a plan') }}</option>
                    @forelse ($plan as $item)
                        <option value="{{ $item->id }}">{{ $item->plan_name }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div class="col-lg-3">
                <a href="#" id="calculate-btn" class="sp_theme_btn w-100"> {{ __('Calculate Earning') }}</a>
            </div>
        </div>
    </div>
</div>


@push('style')
    <style>
         .tradingview-widget-container {
            height: 46px !important;
        }
        
        .tradingview-widget-copyright {
            display: none;
        }
    </style>
@endpush
