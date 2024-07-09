@extends('backend.layout.master')

@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>{{__($pageTitle)}}</h1>
      </div>


    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">

                        @csrf

                        <div class="row">

                            <div class="form-group col-md-6 mb-3">
                                <label>{{__('Analytics Id')}}</label>
                                <input type="text" name="analytics_key" class="form-control form_control" placeholder="Analytics Id"  value="{{@$general->analytics_key}}">
                               

                            </div>

                            <div class="form-group col-md-6">

                                <label for="">{{__('Allow Analytics')}}</label>

                                <select name="analytics_status" id="" class="form-control selectric">
                                
                                    <option value="1" {{@$general->analytics_status==1 ? 'selected' : ''}}>{{__('Yes')}}</option>
                                    <option value="0" {{@$general->analytics_status==0 ? 'selected' : ''}}>{{__('No')}}</option>

                                </select>

                            </div>
                            
                            <div class="form-group col-md-12">

                               <button type="submit" class="btn btn-primary float-right">{{__('Analytics Update')}}</button>

                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>

@endsection


