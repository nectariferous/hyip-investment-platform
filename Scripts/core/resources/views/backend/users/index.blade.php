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

                        <div class="card-header">
                            <div class="d-inline-flex">
                                <?= filterByVariousType([
                                        'model' => 'User',
                                        'text' => [
                                            'placeholder' => 'Search emails',
                                            'name' => 'search',
                                            'id' => 'search_text',
                                            'filter_colum' => 'email'
                                        ],
                                        
                                        'select' => [
                                            'options' => [
                                                '1' => 'Active',
                                                '0' => 'Inactive',
                                            ],
                                            'name' => 'filter',
                                            'id' => 'optionFilter',
                                            'filter_colum' => 'status'
                                        ],
                                    ]) ?>

                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table" id="example">
                                    <thead>
                                        <tr>

                                            <th>{{ __('Sl') }}</th>
                                            <th>{{ __('Full Name') }}</th>
                                            <th>{{ __('Phone') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('Country') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>

                                        </tr>

                                    </thead>

                                    <tbody id="filter_data">

                                        @forelse($users as $key => $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->fullname }}</td>

                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ @$user->address->country ?? 'N/A' }}</td>
                                                <td>

                                                    @if ($user->status)
                                                        <span class='badge badge-success'>{{ __('Active') }}</span>
                                                    @else
                                                        <span class='badge badge-danger'>{{ __('Inactive') }}</span>
                                                    @endif

                                                </td>

                                                <td>

                                                    <a href="{{ route('admin.user.details', $user) }}"
                                                        class="btn btn-sm btn-outline-primary"><i class="fa fa-eye mr-2"></i>{{ __('Details') }}</a>

                                                </td>


                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="100%">{{ __('No Data Found') }}</td>
                                            </tr>
                                        @endforelse



                                    </tbody>
                                </table>
                            </div>
                        </div>


                        @if ($users->hasPages())
                            <div class="card-footer">
                                {{ $users->links('backend.partial.paginate') }}
                            </div>
                        @endif

                    </div>



                </div>


            </div>
        </section>
    </div>
@endsection
