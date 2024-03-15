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
                   Sign up Patient
                </div>
                <div class="card-body">
                
                <form method="post" action="{{route('physician/sign-up-patient')}}">
                    @csrf

                    @include('errors.error-message')
                @include('success.success-message')

                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group row mt-3 {{auth()->user()->roles[0]->slug !== 'physician' ? 'required' : '' }}">
                                <label for="physicians_name" class="col-md-2 col-form-label">Physician</label>
                                <div class="col-md-6">
                                    @if( auth()->user()->roles[0]->slug === 'physician' && auth()->user()->can('sign-up-patient'))
                                        <input type="text" class="form-control-plaintext" id="physicians_name" value="Dr. John Doe, GP, MD, ABC">
                                    @elseif( auth()->user()->roles[0]->slug === 'nurse' && auth()->user()->can('sign-up-patient') || auth()->user()->roles[0]->slug === 'admin' && auth()->user()->can('sign-up-patient') )
                                        <select class="form-control" id="physician" name="physician">
                                            <option>Select Physician</option>
                                            @foreach ($physicians as $item)
                                                <option value="{{$item->_uid}}" {{ old('physician') == $item->_uid ? 'selected' : '' }}>{{$item->first_name . ' ' . $item->last_name}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row required mt-3">
                                <label for="first_name" class="col-md-3 col-form-label">First Name</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{old('first_name')}}" autocomplete="off" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row required mt-3">
                                <label for="last_name" class="col-md-3 col-form-label">Last Name</label>
                                <div class="col-md-9">
                                    <input type="text" name="last_name" class="form-control" id="last_name" value="{{old('last_name')}}" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="dob" class="col-md-3 col-form-label">Date of birth</label>
                                <div class="col-md-9">
                                    <input type="date" class="form-control" id="dob" name="dob" value="{{old('dob')}}" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="gender" class="col-md-3 col-form-label">Gender</label>
                                <div class="col-md-9">
                                    <select id="gender" name="gender" required class="form-control">
                                        <option value="{{old('')}}"></option>
                                        @foreach ($genders as $item)
                                            <option value="{{$item->_uid}}" {{ old('gender') == $item->_uid ? 'selected' : '' }}>{{$item->gender}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5>Contact Information</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required row mt-3">
                                <label for="primary_phone_no" class="col-md-4 col-form-label">Primary Phone No.</label>
                                <div class="col-md-8">
                                    <input class="form-control phone" id="primary_phone_no" name="primary_phone_no" value="{{old('primary_phone_no')}}" autocomplete="off" type="tel" required />
                                    <span id="valid-msg" class="hide">✓ Valid</span>
                                    <span id="error-msg" class="hide"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="secondary_phone_no" class="col-md-4 col-form-label">Secondary Phone No.</label>
                                <div class="col-md-8">
                                    <input class="form-control phone" id="secondary_phone_no" name="secondary_phone_no" value="{{old('secondary_phone_no')}}" autocomplete="off" type="tel" />
                                    <span id="s-valid-msg" class="hide">✓ Valid</span>
                                    <span id="s-error-msg" class="hide"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="email_address" class="col-md-4 col-form-label">Email Address</label>
                                <div class="col-md-8">
                                    <input class="form-control" id="email_address" name="email_address" value="{{old('email_address')}}" autocomplete="off" type="email" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5>Service Request</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required row mt-3">
                                <label for="" class="col-md-3 col-form-label">RPM Service</label>
                                <div class="col-md-9">
                                    <select id="rpm_service" name="rpm_service" class="form-control">
                                        <option value="{{old('rpm_service')}}"></option>
                                        @foreach ($rpm_services as $item)
                                            <option value="{{$item->slug}}" {{ old('rpm_service') == $item->slug ? 'selected' : '' }}>{{$item->rpm_service}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="service_duration" class="col-md-4 col-form-label">Service Duration</label>
                                <div class="col-md-4">
                                    <select class="form-control" id="service_duration" name="service_duration" >
                                        @foreach ($service_duration as $item)
                                            <option value="{{$item->_uid}}" {{ old('service_duration') == $item->_uid ? 'selected' : '' }}>{{$item->duration}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" id="duration_value" >
                                            <option value="{{old('')}}">Months</option>
                                    </select>
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
                                        <select id="before_meals_lower" name="before_meals_lower" required class="form-control">
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
                                        <select id="before_meals_upper" name="before_meals_upper" required class="form-control">
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
                                        <select id="after_meals" name="after_meals" required class="form-control">
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
                                        <textarea cols="3" rows="3" name="bg_comments" id="bg_comments" class="form-control">{{old('bg_comments')}}</textarea>
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
                                        <select id="systolic_lower" name="systolic_lower" required class="form-control">
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
                                        <select id="systolic_upper" name="systolic_upper" required class="form-control">
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
                                        <select id="diastolic_lower" name="diastolic_lower" required class="form-control">
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
                                        <select id="diastolic_upper" name="diastolic_upper" required class="form-control">
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
                                        <textarea cols="3" rows="3" name="bp_comments" id="bp_comments" class="form-control">{{old('bp_comments')}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </span>

                    <h5>Patient Consent</h5>

                    <div class="required row mt-3">
                        <label for="patient_give_consent" class="col-md-3 col-form-label">Was consent received from Patient?</label>
                        <div class="col-md-4 mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="patient_give_consent" id="patient_give_consent_yes" value="1">
                                <label class="form-check-label" for="patient_give_consent_yes">Yes</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <button type="submit" id="saveChangesBtn" class="btn btn-success" disabled>Save changes</button>
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

        $('#patient_give_consent_yes').change(function() {
            $('#saveChangesBtn').prop('disabled', !$(this).prop('checked'));
        });
    });

</script>

@endsection