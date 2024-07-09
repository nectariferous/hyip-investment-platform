@extends('backend.layout.master')


@section('content')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>


            <div class="row">
                <div class="col-md-12">

                    
                    
                    <div class="card">
                  
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>

                                            <th>{{ __('SL') }}</th>
                                            <th>{{ __('Email') }}</th>                                  

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @forelse($subscribers as $subscribe)

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $subscribe->email}}</td>
                                            
                                            </tr>
                                        @empty


                                            <tr>

                                                <td class="text-center" colspan="100%">
                                                    {{ __('No Data Found') }}
                                                </td>

                                            </tr>



                                        @endforelse



                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if ($subscribers->hasPages())
                            <div class="card-footer">

                                {{ $subscribers->links('backend.partial.paginate') }}

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection



