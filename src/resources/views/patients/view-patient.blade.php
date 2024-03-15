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
                   Patient Information
                </div>
                <div class="card-body">

                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card mb-4 text-white bg-primary">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                            <div class="fs-4 fw-semibold">50 
                                </div>
                            <div>Low Readings</div>
                            </div>
                            <div class="dropdown">
                            <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="icon">
                                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
                                </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                            </div>
                        </div>
                        <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                            <canvas class="chart" id="card-chart1" height="70"></canvas>
                        </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card mb-4 text-white bg-info">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                            <div class="fs-4 fw-semibold">830 <span class="fs-6 fw-normal"></div>
                            <div>Normal Readings</div>
                            </div>
                            <div class="dropdown">
                            <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="icon">
                                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
                                </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                            </div>
                        </div>
                        <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                            <canvas class="chart" id="card-chart2" height="70"></canvas>
                        </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card mb-4 text-white bg-warning">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                            <div class="fs-4 fw-semibold">884 <span class="fs-6 fw-normal"></div>
                            <div>Safe Readings</div>
                            </div>
                            <div class="dropdown">
                            <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="icon">
                                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
                                </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                            </div>
                        </div>
                        <div class="c-chart-wrapper mt-3" style="height:70px;">
                            <canvas class="chart" id="card-chart3" height="70"></canvas>
                        </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card mb-4 text-white bg-danger">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                            <div class="fs-4 fw-semibold">333 <span class="fs-6 fw-normal"></div>
                            <div>Critical Readings</div>
                            </div>
                            <div class="dropdown">
                            <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="icon">
                                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
                                </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                            </div>
                        </div>
                        <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                            <canvas class="chart" id="card-chart4" height="70"></canvas>
                        </div>
                        </div>
                    </div>
                    <!-- /.col-->
                </div>
                
                <form method="post" action="{{route('physician/sign-up-patient')}}">
                    @csrf

                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group row mt-3">
                                <label for="physicians_name" class="col-md-2 col-form-label">Physician</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control-plaintext" id="physicians_name" value="Dr. John Doe, GP, MD, ABC">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="first_name" class="col-md-3 col-form-label">First Name:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control-plaintext" readonly id="first_name" name="first_name" value="{{$patients_details->first_name}}" autocomplete="off" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="last_name" class="col-md-3 col-form-label">Last Name:</label>
                                <div class="col-md-9">
                                    <input type="text" name="last_name" class="form-control-plaintext" id="last_name" value="{{$patients_details->last_name}}" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="dob" class="col-md-3 col-form-label">Date of birth:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control-plaintext" id="dob" name="dob" value="{{ date('M d, Y', strtotime($patients_details->dob))}}" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="gender" class="col-md-3 col-form-label">Gender:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control-plaintext" id="dob" name="dob" value="{{$patients_details->gender}}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5>Contact Information</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="primary_phone_no" class="col-md-4 col-form-label">Primary Phone No.:</label>
                                <div class="col-md-8">
                                    <input class="form-control-plaintext" id="primary_phone_no" name="primary_phone_no" value="{{$patients_details->primary_phone_no}}" autocomplete="off" type="tel" required />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="secondary_phone_no" class="col-md-4 col-form-label">Secondary Phone No.:</label>
                                <div class="col-md-8">
                                    <input class="form-control-plaintext" id="secondary_phone_no" name="secondary_phone_no" value="{{$patients_details->secondary_phone_no}}" autocomplete="off" type="tel" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="email_address" class="col-md-4 col-form-label">Email Address:</label>
                                <div class="col-md-8">
                                    <input class="form-control-plaintext" id="email_address" name="email_address" value="{{$patients_details->email}}" autocomplete="off" type="email" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5>Service Request</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="" class="col-md-3 col-form-label">RPM Service:</label>
                                <div class="col-md-9">
                                    <input class="form-control-plaintext" id="email_address" name="email_address" value="{{$patients_details->rpm_service}}" autocomplete="off" type="email" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="service_duration" class="col-md-4 col-form-label">Service Duration:</label>
                                <div class="col-md-4">
                                    <input class="form-control-plaintext" id="email_address" name="email_address" value="{{$patients_details->duration}} {{ $patients_details->duration != 'Continuous Care' ? 'months' : ''}}" autocomplete="off" type="email" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <span id="bgm" class="hide">
                        <h5>Target</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row mt-3">
                                    <label for="" class="col-md-3 col-form-label">Before Meals</label>
                                    <div class="col-md-2">
                                        <select id="before_meals_lower" name="before_meals_lower" required class="form-control-plaintext">
                                        <option value="{{old('')}}"></option>
                                            @for($r = 40; $r <= 170; $r+=5)
                                                <option value="{{$r}}" {{$r === 80 ? 'selected' : ''}}>{{$r}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-1">
                                        <label for="">-</label>
                                    </div>

                                    <div class="col-md-2">
                                        <select id="before_meals_upper" name="before_meals_upper" required class="form-control-plaintext">
                                            <option value="{{old('')}}"></option>
                                            @for($r = 40; $r <= 170; $r+=5)
                                                <option value="{{$r}}" {{$r === 130 ? 'selected' : ''}}>{{$r}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="">mg/dL</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row mt-3">
                                    <label for="after_meals" class="col-md-4 col-form-label">2 hours after meals: < </label>
                                    <div class="col-md-2">
                                        <select id="after_meals" name="after_meals" required class="form-control-plaintext">
                                            <option value="{{old('')}}"></option>
                                            @for($r = 80; $r <= 200; $r+=5)
                                                <option value="{{$r}}" {{$r === 180 ? 'selected' : ''}}>{{$r}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">mg/dL</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5>Additional Comments</h5>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row mt-3">
                                    <label for="bg_comments" class="col-md-3 col-form-label">Comments</label>
                                    <div class="col-md-12">
                                        <textarea cols="3" rows="3" name="bg_comments" id="bg_comments" class="form-control-plaintext">{{old('bg_comments')}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </span>

                    <span id="bpm" class="hide">
                        <h5>Target</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row mt-3">
                                    <label for="" class="col-md-3 col-form-label">Systolic</label>
                                    <div class="col-md-2">
                                        <select id="systolic_lower" name="systolic_lower" required class="form-control-plaintext">
                                            <option value="{{old('')}}"></option>
                                            @for($r = 80; $r <= 160; $r+=5)
                                                <option value="{{$r}}" {{$r === 100 ? 'selected' : ''}}>{{$r}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-1">
                                        <label for="">-</label>
                                    </div>

                                    <div class="col-md-2">
                                        <select id="systolic_upper" name="systolic_upper" required class="form-control-plaintext">
                                            <option value="{{old('')}}"></option>
                                            @for($r = 80; $r <= 160; $r+=5)
                                                <option value="{{$r}}" {{$r === 140 ? 'selected' : ''}}>{{$r}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="">mmHg</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row mt-3">
                                    <label for="" class="col-md-4 col-form-label">Diastolic</label>
                                    <div class="col-md-2">
                                        <select id="diastolic_lower" name="diastolic_lower" required class="form-control-plaintext">
                                            <option value="{{old('')}}"></option>
                                            @for($r = 40; $r <= 120; $r+=5)
                                                <option value="{{$r}}" {{$r === 60 ? 'selected' : ''}}>{{$r}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-1">
                                        <label for="">-</label>
                                    </div>

                                    <div class="col-md-2">
                                        <select id="diastolic_upper" name="diastolic_upper" required class="form-control-plaintext">
                                            <option value="{{old('')}}"></option>
                                            @for($r = 40; $r <= 120; $r+=5)
                                                <option value="{{$r}}" {{$r === 90 ? 'selected' : ''}}>{{$r}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="">mmHg</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5>Additional Comments</h5>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row mt-3">
                                    <label for="bp_comments" class="col-md-3 col-form-label">Comments</label>
                                    <div class="col-md-12">
                                        <textarea cols="3" rows="3" name="bp_comments" id="bp_comments" class="form-control-plaintext">{{old('bp_comments')}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </span>

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

<script>
    $(document).ready(function(){

        $('#bpm, #bgm, #duration_value').hide();

        $('#rpm_service').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'bpm') {
                $('#bpm').show();
                $('#bgm').hide();
            } else if(selectedValue === 'bgm') {
                $('#bpm').hide();
                $('#bgm').show();
            } else {
                $('#bpm, #bgm').hide();
            }
        });

        $('#service_duration').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'cc') {
                $('#duration_value').hide();
            } else {
                $('#duration_value').show();
            }
        });

    $(".phone").each(function(){
        var iti = window.intlTelInput(this, {
            initialCountry: 'ky',
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        var errorMsg = $("#error-msg");
        var validMsg = $("#valid-msg");
        const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        $(this).on("keyup", function() {
            if( $(this)[0].id === "primary_phone_no" ){
                if( $(this)[0].value === '' ){
                    $("#error-msg").html('');
                } else {
                    if (iti.isValidNumber()) {
                        $("#valid-msg").removeClass("hide");
                        $("#error-msg").addClass("hide");
                    } else {
                        $("#valid-msg").addClass("hide");
                        $("#error-msg").removeClass("hide");
                        $("#error-msg").addClass("error");
                        $("#error-msg").html(errorMap[iti.getValidationError()]);
                    }
                }
            } else if($(this)[0].id === "secondary_phone_no"){
                if( $(this)[0].value === '' ){
                    $("#s-error-msg").html('');
                } else {
                    if (iti.isValidNumber()) {
                        $("#s-valid-msg").removeClass("hide");
                        $("#s-error-msg").addClass("hide");
                    } else {
                        $("#s-valid-msg").addClass("hide");
                        $("#s-error-msg").removeClass("hide");
                        $("#s-error-msg").addClass("error");
                        $("#s-error-msg").html(errorMap[iti.getValidationError()]);
                    }
                }
            }
        });
    });
});

</script>

@endsection