@extends('backend.layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>

            <div class="row">

                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">

                        <div class="card-body text-center">
                            <ul class="list-group">

                                @foreach ($user->kyc_infos as $key => $proof)
                                    @if (is_array($proof))
                                        <li class="list-group-item d-flex justify-content-between">

                                            <span>{{ __(str_replace('_', ' ', ucwords($key))) }}</span>
                                            <span class="text-right"><img src="{{ getFile('user', $proof['file']) }}"
                                                    alt="" class="w-50 "></span>

                                        </li>

                                        @continue
                                    @endif

                                    <li class="list-group-item d-flex justify-content-between">

                                        <span>{{ __(str_replace('_', ' ', ucwords($key))) }}</span>
                                        <span>{{ __($proof) }}</span>

                                    </li>
                                @endforeach

                            </ul>


                            @if($user->kyc == 2)
                            <div class="col-md-12 mt-4 text-right">

                                <button class="btn btn-success approve"
                                    data-url="{{ route('admin.user.kyc.status', ['approve', $user->id]) }}">
                                    <i class="fa fa-check"></i>
                                    {{ __('Approve') }}
                                </button>


                                <button class="btn btn-danger reject"
                                    data-url="{{ route('admin.user.kyc.status', ['reject', $user->id]) }}">
                                    <i class="fa fa-times"></i>
                                    {{ __('Reject') }}
                                </button>
                            </div>

                            @endif


                            



                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="approve" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('KYC Request Update') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{__('Are You Sure to Approve')}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('Approve')}}</button>
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="reject" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('KYC Request Update') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{__('Are You Sure to Reject')}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('Reject')}}</button>
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')

<script>
    $(function(){
        $('.approve').on('click', function(){
           const modal = $('#approve')


           modal.find('form').attr('action', $(this).data('url'))


           modal.modal('show')
        })


        $('.reject').on('click', function(){
           const modal = $('#reject')


           modal.find('form').attr('action', $(this).data('url'))


           modal.modal('show')
        })
    })
</script>
    
@endpush
