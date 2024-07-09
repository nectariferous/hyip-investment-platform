@extends('backend.layout.master')
@section('content')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Sl') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Subject') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($emailTemplates as $key => $email)
                                    <tr>
                                        <td>{{ $key + $emailTemplates->firstItem() }}</td>
                                        <td>{{ str_replace('_', ' ', $email->name) }}</td>
                                        <td>{{ $email->subject }}</td>
                                        <td>
                                            <a href="{{ route('admin.email.templates.edit', $email) }}"
                                                class="btn btn-md btn-primary"><i class="fa fa-pen"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">{{ __('No Email Template Found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($emailTemplates->hasPages())
                    <div class="card-footer">
                        {{ $emailTemplates->links('backend.partial.paginate') }}
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
