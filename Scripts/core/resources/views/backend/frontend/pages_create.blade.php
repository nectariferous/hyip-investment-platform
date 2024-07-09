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
                        <div class="card-body">
                            <div class="row">
                                <form action="" method="POST" class="col-md-12">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-12">
                                            <h6>{{ __('Add Sections') }}</h6>

                                            <p>{{ __('Select The Section You Want to add your page') }}</p>


                                            <div class="d-flex justify-content-start flex-wrap">

                                                @foreach ($sections as $key => $section)

                                                    <div class="col-md-3 my-2 selectable" id="{{ $key }}"
                                                        data-clicked="on" data-section="{{ $key }}">
                                                        <div class="p-3 bg-primary text-center">
                                                            <span class="text-white counter">

                                                            </span>
                                                            <span
                                                                class="text-white text-center">{{ frontendFormatter($key) }}
                                                            </span>


                                                        </div>
                                                    </div>
                                                @endforeach

                                                <input type="hidden" name="sections[]" id="section_val">
                                            </div>



                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="">{{ __('Page Name') }}</label>

                                            <input type="text" name="page" class="form-control" placeholder="Page Name"
                                                required>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="">{{ __('Page Order') }}</label>

                                            <input type="text" name="page_order" class="form-control"
                                                placeholder="Page Order" required>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="">{{ __('status') }}</label>

                                            <select name="status" class="form-control selectric">

                                                <option value="1">{{ __('Active') }}</option>
                                                <option value="0">{{ __('Inactive') }}</option>

                                            </select>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="">{{ __('Is Dropdown') }}</label>

                                            <select name="dropdown" class="form-control selectric">

                                                <option value="1">{{ __('Yes') }}</option>
                                                <option value="0">{{ __('No') }}</option>

                                            </select>

                                        </div>





                                        <div class="form-group col-md-12">

                                            <label for="">{{ __('Seo Description') }}</label>
                                            <textarea name="seo_description" id="" cols="30" rows="5"
                                                class="form-control">{{ old('seo_description') }}</textarea>

                                        </div>

                                        <div class="form-group col-md-12 custom-section d-none">

                                            <label for="">{{ __('Custom Section') }}</label>
                                            <textarea name="custom_section" id="" cols="30" rows="5"
                                                class="form-control summernote">{{ old('custom_section') }}</textarea>

                                        </div>


                                        <div class="col-md-12">
                                            <button type="submit"
                                                class="btn btn-primary float-right">{{ __('Add Page') }}</button>
                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


        @endsection

        @push('script')
            <script>
                $(function() {

                    "use strict";

                    let sections = [];


                    $('.selectable').each(function(index) {

                        $(this).on('click', function() {

                            if ($(this).attr('data-clicked') == 'off') {

                                $(this).children().removeClass('bg-success').addClass('bg-primary');

                                let value = $(this).attr('data-section')

                                let index = sections.indexOf(value)


                                sections.splice(index, 1)

                                $(this).attr('data-clicked', 'on')


                                counter(sections, value)

                                $('#section_val').val(JSON.stringify(sections));


                                return false;


                            }

                            $(this).children().removeClass('bg-primary').addClass('bg-success');

                            $(this).attr('data-clicked', 'off');

                            sections.push($(this).data('section'))

                            $(this).children().find('.counter').removeClass('d-none').text(sections.indexOf(
                                $(this).data('section')) + 1)

                            $('#section_val').val(JSON.stringify(sections));



                        })
                    })


                    function counter(sections, romovalSectionId) {

                        if (sections.indexOf(romovalSectionId)) {
                            $('#' + romovalSectionId).children().find('.counter').addClass('d-none')
                        }

                        for (let index = 0; index < sections.length; index++) {

                            let counterIndex = sections.indexOf(sections[index]) + 1;

                            $('#' + sections[index]).children().find('.counter').removeClass('d-none')
                                .text(counterIndex)



                        }

                    }


                })
            </script>
        @endpush
