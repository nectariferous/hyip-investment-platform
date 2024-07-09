@extends('backend.layout.master')


@section('content')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header justify-content-end">
                            <a href="{{ route('admin.time.create') }}" class="btn btn-primary" data-toggle="modal" data-target="#time"> <i
                                    class="fa fa-plus"></i>
                                {{ __('Add Time') }}</a>
                            
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>

                                            <th>{{ __('SL') }}.</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Time') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($times as $time)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $time->name }}</td>
                                                <td>{{ $time->time }} {{ __('Hours') }}</td>

                                                <td>
                                                    <a href="#" data-collection="{{ $time }}" data-href="{{route('admin.time.update', $time->id)}}"
                                                        class="btn btn-md btn-primary editTime"><i class="fa fa-pen mr-2"></i
                                                            class="fa fa-pen mr-2"></i>{{ __('Edit') }}</a>
                                                </td>
                                            </tr>
                                        @empty

                                            <tr>
                                                <td class="text-center" colspan="100%">
                                                    {{ __('No Time Created Yet') }}</td>
                                            </tr>

                                        @endforelse


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>




    <div class="modal fade" id="time" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{ __('ADD NEW TIME')}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.time.store') }}"  method="POST" >
                    @csrf
                <div class="form-group">
                    <label>{{ __('Time Name: ')}}</label>
                    <input type="text" class="form-control" value="" name="name" placeholder="{{ __('Ex: Day, Week, Month...') }}" required>
                </div>

                <div class="form-group">
                    <label>{{ __('Time in Hours')}}</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="time" value=""   placeholder="{{ __('Ex: 24h, 4h...') }}" required>
                        <div class="input-group-prepend">
                            <div class="input-group-text">{{ __('Hours')}}</div>
                        </div>
                    </div>
                </div>
              
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ __('Save')}}</button>
            </form>
              <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close')}}</button>
            </div>
          </div>
        </div>
      </div>






      <div class="modal fade" id="edittime" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit TIME')}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                   
                <div class="form-group">
                    <label>{{ __('Time Name: ')}}</label>
                    <input type="text" class="form-control" value="" id="name" name="name" placeholder="{{ __('Ex: Day, Week, Month...') }}" required>
                </div>

                <div class="form-group">
                    <label>{{ __('Time in Hours')}}</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="time" value=""   placeholder="{{ __('Ex: 24h, 4h...') }}" required>
                        <div class="input-group-prepend">
                            <div class="input-group-text">{{ __('Hours')}}</div>
                        </div>
                    </div>
                </div>
              
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ __('Save')}}</button>
            </form>
              <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close')}}</button>
            </div>
          </div>
        </div>
      </div>

      
@endsection


@push('script')

            <script>
                $(function() {
                    'use strict'

                    $('.editTime').on('click', function() {
                        const modal = $('#edittime')

                        let item=$(this).data('collection');                 

                        modal.find('input[name=name]').val(item.name);

                        modal.find('input[name=time]').val(item.time);       


                        modal.find('form').attr('action', $(this).data('href'))

                        modal.modal('show')
                    })
                })
            </script>

 @endpush

