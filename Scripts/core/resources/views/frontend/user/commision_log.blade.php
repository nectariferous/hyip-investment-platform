@extends(template().'layout.master2')


@section('content2')
    <div class="dashboard-body-part">
        <div class="card">
            <div class="card-body text-end">
                <form action="" method="get" class="d-inline-flex">
                    <input type="date" class="form-control me-3" placeholder="Search User" name="date">
                    <button type="submit" class="sp_theme_btn">{{__('Search')}}</button>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table sp_site_table">
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
@endsection
