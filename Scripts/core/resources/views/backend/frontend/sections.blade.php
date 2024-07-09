@extends('backend.layout.master')
@section('breadcrumb')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Manage Sections') }}</h1>
        </div>
    </section>
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Sections') }}</h4>

                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>{{ __('Sl') }}.</th>
                                <th>{{ __('Section Name') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>

                            @forelse($sections as $key => $section)
                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ ucwords($key) }}
                                    </td>

                                    <td>

                                        <a href="{{ route('admin.frontend.section.manage', ['name' => $key]) }}"
                                            class="btn btn-icon btn-primary"><i class="fa fa-cog"></i></a>

                                    </td>
                                </tr>
                            @empty

                                <tr>

                                    <td class="text-center text-danger" colspan="100%">{{ __('No Data Found') }}</td>

                                </tr>
                            @endforelse

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
