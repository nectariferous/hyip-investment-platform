@extends(template().'layout.master2')

@section('content2')
    <div class="dashboard-body-part">
        <div class="row gy-4">
        
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{ __('KYC Verification') }}</h4>
                    </div>

                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @foreach ($general->kyc as $proof)
                                    @if ($proof['type'] == 'text')
                                        <div class="form-group col-md-12">
                                            <label for=""
                                                class="mb-2 mt-2">{{ __($proof['label']) }}</label>
                                            <input type="text"
                                                name="{{ strtolower(str_replace(' ', '_', $proof['field_name'])) }}"
                                                class="form-control bg-dark"
                                                {{ $proof['validation'] == 'required' ? 'required' : '' }}>
                                        </div>
                                    @endif
                                    @if ($proof['type'] == 'textarea')
                                        <div class="form-group col-md-12">
                                            <label for=""
                                                class="mb-2 mt-2">{{ __($proof['label']) }}</label>
                                            <textarea name="{{ strtolower(str_replace(' ', '_', $proof['field_name'])) }}" class="form-control bg-dark"
                                                {{ $proof['validation'] == 'required' ? 'required' : '' }}></textarea>
                                        </div>
                                    @endif

                                    @if ($proof['type'] == 'file')
                                        <div class="form-group col-md-12">
                                            <label for=""
                                                class="mb-2 mt-2">{{ __($proof['label']) }}</label>
                                            <input type="file"
                                                name="{{ strtolower(str_replace(' ', '_', $proof['field_name'])) }}"
                                                class="form-control bg-dark"
                                                {{ $proof['validation'] == 'required' ? 'required' : '' }}>
                                        </div>
                                    @endif
                                @endforeach


                                <div class="form-group">
                                    <button class="sp_theme_btn mt-4"
                                        type="submit">{{ __('KYC Verification') }}</button>

                                </div>


                            </div>



                        </form>



                    </div>

                </div>




            </div>
        </div>
    </div>
@endsection
