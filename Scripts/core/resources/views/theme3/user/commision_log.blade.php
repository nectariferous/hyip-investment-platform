@extends(template().'layout.master2')


@section('content2')
    <div class="dashboard-body-part">

        <div class="mobile-page-header">
            <h5 class="title">{{ __('Referral History') }}</h5>
            <a href="{{ route('user.dashboard') }}" class="back-btn"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
        </div>
        
        <div class="site-card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h5 class="mb-sm-0 mb-2">{{ __('Referral Log') }}</h5>
                <form action="" method="get" class="d-inline-flex">
                    <input type="date" class="form-control form-control-sm me-3" placeholder="Search User" name="date">
                    <button type="submit" class="btn main-btn btn-sm">{{__('Search')}}</button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table site-table">
                        <thead>
                            <tr class="bg-yellow">
                                <th scope="col">{{ __('Commison From') }}</th>
                                <th scope="col">{{ __('Amount') }}</th>
                                <th scope="col">{{ __('Return Details') }}</th>
                                <th scope="col">{{ __('Commision Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($commison as $item)
                                <tr>
                                    <td data-caption="From">{{ @$item->commissionFrom->username }}</td>
                                    <td data-caption="To">{{ number_format($item->amount, 2) }}
                                        {{ @$general->site_currency }}</td>
                                    <td>{{$item->purpouse}}</td>
                                    <td data-caption="{{__('date')}}">{{ $item->created_at->format('y-m-d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td data-caption="Data" class="text-center" colspan="100%">{{ __('No Data Found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $commison->links('backend.partial.paginate') }}
                </div>
            </div>
        </div>
    </div>
@endsection
