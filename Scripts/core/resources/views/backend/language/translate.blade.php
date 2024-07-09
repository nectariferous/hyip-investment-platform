@extends('backend.layout.master')


@section('content')

    <div class="main-content">

        <div class="language-index-row">
            <div class="card">

                <div class="card-header">
                    <div class="w-100">
                        <div class="input-group mb-3">
                            <select class="custom-select export selectric" id="inputGroupSelect02">
                                <option selected> {{ __('Select Language') }} </option>
                                @foreach ($languages as $la)
                                    <option value="{{ $la->short_code }}">{{ __($la->name) }}</option>
                                @endforeach

                            </select>
                            <div class="input-group-append">
                                <label class="input-group-text bg-primary text-white custom-imp"
                                    for="inputGroupSelect02">{{ __('Import From') }}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <form action="" method="post">
                        @csrf
                        <div class="text-right text-right-to-left my-3">
                            <button type="button" class="btn btn-primary addmore"> <i class="fa fa-plus"></i>
                                {{ __('Add More') }}</button>

                            <button type="submit" class="btn btn-success">{{ __('Update Language') }}</button>

                        </div>

                        <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>{{ __('Key') }}</th>
                                    <th>{{ __('Value') }}</th>
                                </tr>
                            </thead>

                            <tbody id="append">

                                @forelse ($translators as $key => $translate)

                                    <tr>
                                        <td>
                                            <textarea type="text" name="key[]" class="form-control">{{ clean($key) }}</textarea>
                                        </td>
                                        
                                        <td>
                                            <textarea type="text" name="value[]" class="form-control">{{ clean($translate) }}</textarea>
                                        </td>

                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script>
        'use strict'
        $(function() {
            let i = {{ $translators != null ? count($translators) : 0 }};
            $('.addmore').on('click', function() {
                let html = `
                        <tr>
                            <td>
                                <textarea type="text" name="key[]" class="form-control"></textarea>
                            </td>
                            <td>
                                <textarea type="text" name="value[]" class="form-control"></textarea>
                            </td>

                        </tr>
            `;
                i++;
                $('#append').prepend(html);
            })

            $('.export').on('change', function() {

                let lang = $(this).val();
                let current = "{{ request()->lang }}"
                let text = "Are You Sure to Import From " + lang + " . Your Current Data will be Removed";
                if (confirm(text) == true) {

                    $.ajax({
                        url: "{{ route('admin.language.import') }}",
                        method: "GET",
                        data: {
                            import: lang,
                            current: current
                        },
                        success: function(response) {
                            iziToast.success({
                                message: "{{__('Language Updated Successfully')}}",
                                position: 'topRight'
                            });
                            window.location.reload(true)
                        }
                    })
                }

            })
        })
    </script>

@endpush
