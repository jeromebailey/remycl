@extends('layouts.main')

@section('head-links')
  @include('layouts.common.meta-data')
  <title>{{ config('app.name', 'Laravel') }}</title>
  @include('layouts.common.css-links')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                   Premium Payment
                </div>
                <div class="card-body">
                
                <form method="post" action="{{route($role_slug .'/add-client-premium-payment')}}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="premium-amount" class="col-md-3 col-form-label">Amount:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control-plaintext" readonly id="premium-amount" name="premium-amount" value="{{$client_details->policy_no}}" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="primary_phone_no" class="col-md-4 col-form-label">Primary Phone No.:</label>
                                <div class="col-md-8">
                                    <input class="form-control-plaintext" id="primary_phone_no" name="primary_phone_no" value="{{$client_details->phone_no}}" autocomplete="off" type="tel" required />
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                
                </div>
            </div>
        </div>
    </div>

    <!-- /.row-->
    @endsection

@section('scripts')
@include('layouts.common.scripts')
<script
src="https://code.jquery.com/jquery-3.7.0.min.js"
integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

<script src="{{asset('js/intlTelInput.min.js')}}"></script>

@endsection