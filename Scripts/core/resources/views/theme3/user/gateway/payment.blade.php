@extends(template().'layout.master2')

@section('content2')
    <div class="dashboard-body-part">
        <div class="site-card">
            <div class="card-body">
                <div class="row gy-4">
                    @foreach ($gateways as $gateway)
                        <div class="col-md-4">
                            <div class="thumbnail">
                                    <div class="image-area">
                                        <img src="{{ getFile('gateways' , $gateway->gateway_image) }}"
                                        alt="Lights" class="w-100 gateway-image">
                                    </div>
                                    <div class="caption text-center mt-3">
                                        <a href=""></a>
                                        <form method="post" action="{{route('plan.subscribe', $plan->id)}}">
                                            @csrf
                                            <input type="hidden" name="gateway" id="" value="{{$gateway->id}}">

                                            <button type="submit" class="btn main-btn w-100">
                                            {{__('Pay Via '.$gateway->gateway_name)}}</button>
                                        </form>
                                    </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')

<style>
    .image-area{
       height:300px;
    }
    .gateway-image{
        width:100%;
        height:100%;
        object-fit:cover;
    }


</style>

@endpush
