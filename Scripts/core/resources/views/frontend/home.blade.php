@extends(template().'layout.master')


@section('content')



    @include('frontend.sections.banner')
    @if ($sections->sections != null)
        @foreach ($sections->sections as $sections)
            @include('frontend.sections.'.$sections)
        @endforeach
    @endif


    <div class="modal fade" id="calculationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Profit calculate') }}</h5>
                    <button type="button" class="close sp_btn sp_btn_warning" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="profit">

                </div>
            </div>
        </div>

    @endsection


    @push('script')
        <script>
            'use strict';
            $(document).ready(function() {
                $(document).on('click', '#calculate-btn', function() {

                    let modal = $('#calculationModal');

                    $('.selectplan').text('');
                    $('.amount').text('');
                    let id = $('#plan').val();
                    let amount = $('#amount').val();
                    var url = "{{ route('user.investmentcalculate', ':id') }}";
                    url = url.replace(':id', id);
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data: {
                            amount: amount,
                            selectplan: id
                        },
                        success: (data) => {
                            if (data.message) {
                                iziToast.error({
                                    message: data.message + ' ' + Number(data.amount).toFixed(2),
                                    position: 'topRight',
                                });

                            } else {
                                $('#profit').html(data);
                                modal.modal('show');
                            }


                        },
                        error: (error) => {
                            if (typeof(error.responseJSON.errors.amount) !== "undefined") {
                                iziToast.error({
                                    message: error.responseJSON.errors.amount,
                                    position: 'topRight',
                                });
                            }
                            if (typeof(error.responseJSON.errors.selectplan) !== "undefined") {
                                iziToast.error({
                                    message: error.responseJSON.errors.selectplan,
                                    position: 'topRight',
                                });
                            }
                        }
                    })
                });



            });
        </script>
    @endpush


    @push('style')

    <style>
        #profit-table tr td{
            color: #fff;
        }
    </style>

    @endpush
