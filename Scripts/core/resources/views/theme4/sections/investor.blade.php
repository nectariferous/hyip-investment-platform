@php
$investor = content('investor.content');

$topInvestor = App\Models\Payment::where('payment_status',1)->groupBy('user_id')
    ->selectRaw('sum(amount) as sum, user_id')
    ->orderBy('sum', 'desc')
    ->get()
    ->map(function ($a) {
        return App\Models\User::find($a->user_id);
    });

@endphp

<section class="investor-section sp_pt_120 sp_pb_120 sp_separator_bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <div class="sp_site_header  wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                    <h2 class="sp_site_title">{{ @$investor->data->title }}</h2>
                </div>
            </div>
        </div>
        <div class="investor-slider">
            @foreach ($topInvestor as $top)
                <div class="single-slide">
                    <div class="investor-item">
                        <div class="investor-thumb">
                            <div class="investor-thumb-inner">
                                <img src="{{ getFile('user', @$top->image) }}" alt="image">
                            </div>
                        </div>
                        <div class="investor-content">
                            <h4 class="name">{{$top->full_name}}</h4>
                            <p class="mt-2">{{__('Invest Amount')}} <span class="site-color">{{number_format($top->payments()->where('payment_status',1)->sum('amount'),2) .' '. $general->site_currency}}</span></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>