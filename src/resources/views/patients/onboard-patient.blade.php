@extends('layouts.main')

@section('head-links')
  @include('layouts.common.meta-data')
  <title>{{ config('app.name', 'Laravel') }}</title>
  @include('layouts.common.css-links')
  
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                   Onboard Patient
                </div>
                <div class="card-body">
                
                <form method="post" action="{{route('admin/onboard-patient', ['id'=>$id])}}">
                    @csrf

                    @include('errors.error-message')
                @include('success.success-message')

                <div>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="patient-information-tab" data-toggle="tab" href="#patient-informationr" role="tab" aria-controls="patient-informationr" aria-selected="true">Patient Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="nok-tab" data-toggle="tab" href="#nok" role="tab" aria-controls="nok" aria-selected="false">Next of Kin/Caregiver</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="assigned-device-tab" data-toggle="tab" href="#assigned-device" role="tab" aria-controls="assigned-device" aria-selected="false">Assigned Device</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="objective-tab" data-toggle="tab" href="#objectiver" role="tab" aria-controls="objectiver" aria-selected="false">Onboard Checklist</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-4" id="myTabContent">
                        <div class="tab-pane fade show active" id="patient-informationr" role="tabpanel" aria-labelledby="patient-information-tab">
                            <div class="container">@include('patients.onboarding.patient-information')</div>
                        </div>
                        <div class="tab-pane fade" id="nok" role="tabpanel" aria-labelledby="nok-tab">
                            <div class="conatiner">@include('patients.onboarding.next-of-kin')</div>
                        </div>
                        <div class="tab-pane fade" id="assigned-device" role="tabpanel" aria-labelledby="assigned-device-tab">
                            <div class="container">@include('patients.onboarding.device-information')</div>
                        </div>
                        <div class="tab-pane fade" id="objectiver" role="tabpanel" aria-labelledby="objective-tab">
                            @include('patients.onboarding.onboard-checklist')
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



<script>




</script>

@endsection