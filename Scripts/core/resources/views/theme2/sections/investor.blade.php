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

<!-- investor section start -->
<section id="investor" class="investor-section s-pt-100 s-pb-100 separator-bg">
    <div class="investor-el">
        <img src="{{ getFile('investor', @$investor->data->image) }}" alt="image">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xxl-4 col-lg-5 text-md-start text-center">
                <div class="section-header">
                    <h2 class="sp_site_title">{{ @$investor->data->title }}</h2>
                </div>
            </div>
        </div>
        <div class="investor-slider wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="0.5s">
            @foreach ($topInvestor as $top)
                <div class="single-slide">
                    <div class="investor-item">
                        <div class="thumb"
                            style="background-image: url('{{ getFile('user', @$top->image) }}');">
                        </div>
                        <div class="content">
                            <h4>{{$top->full_name}}</h4>
                            <p>{{__('Invest Amount')}} <span class="site-color">{{number_format($top->payments()->where('payment_status',1)->sum('amount'),2) .' '. $general->site_currency}}</span></p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
<!-- investor section end -->