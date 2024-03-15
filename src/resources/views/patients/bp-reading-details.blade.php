@extends('layouts.main')

@section('head-links')
  @include('layouts.common.meta-data')
  <title>{{ config('app.name', 'Laravel') }}</title>
  @include('layouts.common.css-links')
  <link rel="stylesheet" href='https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css' />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                  <?php echo ($patient_name === null) ? 'My' : $patient_name ."'s" ?> BP Reading
                </div>
                <div class="card-body">

                @include('errors.error-message')
                @include('success.success-message')

                <div class="row">
                  <div class="col-sm-6 col-lg-3">
                    <div class="card mb-4 text-white bg-primary">
                      <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                          <div class="fs-4 fw-semibold"><a class="bp-status-links" href="{{route('physician/patients-bp-readings-by-status', ['id' => $id, 'statusId' => $low_uuid])}}" class=""><?php echo $low_readings?></a> 
                              </div>
                          <div><a class="bp-status-links" href="{{route('physician/patients-bp-readings-by-status', ['id' => $id, 'statusId' => $low_uuid])}}" class="">Low Readings</a></div>
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
                          <div class="fs-4 fw-semibold"><a class="bp-status-links" href="{{route('physician/patients-bp-readings-by-status', ['id' => $id, 'statusId' => $within_range_uuid])}}" class=""><?php echo $normal_readings?></a> <span class="fs-6 fw-normal"></div>
                          <div><a class="bp-status-links" href="{{route('physician/patients-bp-readings-by-status', ['id' => $id, 'statusId' => $within_range_uuid])}}" class="">Normal Readings</a></div>
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
                          <div class="fs-4 fw-semibold"><a class="bp-status-links" href="{{route('physician/patients-bp-readings-by-status', ['id' => $id, 'statusId' => $high_uuid])}}" class=""><?php echo $high_readings?> </a><span class="fs-6 fw-normal"></div>
                          <div><a class="bp-status-links" href="{{route('physician/patients-bp-readings-by-status', ['id' => $id, 'statusId' => $high_uuid])}}" class="">High Readings</a></div>
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
                          <div class="fs-4 fw-semibold"><a class="bp-status-links" href="{{route('physician/patients-bp-readings-by-status', ['id' => $id, 'statusId' => $high_critical_uuid])}}" class=""><?php echo $high_critical_readings?></a> <span class="fs-6 fw-normal"></div>
                          <div><a class="bp-status-links" href="{{route('physician/patients-bp-readings-by-status', ['id' => $id, 'statusId' => $high_critical_uuid])}}" class="">High Critical Readings</a></div>
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

                
                <table class="table table-bordered table-striped mt-5" id="tableData">
                    <thead>
                        <tr>
                            <th>Reading</th>
                            <th>Pulse</th>
                            <th>Taken On</th>
                            <th>Systolic Status</th>
                            <th>Diastolic Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        @php
                            $systolic_status_class = $diastolic_status_class = "";
                            switch($specific_reading->systolic_status_id)
                            {
                                case 5;
                                    $systolic_status_class = "danger";
                                    break;

                                case 4;
                                    $systolic_status_class = "warning";
                                    break;

                                case 3;
                                    $systolic_status_class = "info";
                                    break;

                                case 2;
                                    $systolic_status_class = "primary";
                                    break;

                                case 1;
                                    $systolic_status_class = "secondary";
                                    break;
                            }

                            switch($specific_reading->diastolic_status_id)
                            {
                                case 5;
                                    $diastolic_status_class = "danger";
                                    break;

                                case 4;
                                    $diastolic_status_class = "warning";
                                    break;

                                case 3;
                                    $diastolic_status_class = "info";
                                    break;

                                case 2;
                                    $diastolic_status_class = "primary";
                                    break;

                                case 1;
                                    $diastolic_status_class = "secondary";
                                    break;
                            }
                        @endphp
                            
                        <tr>
                            <td>{{$specific_reading->systolic}}/{{$specific_reading->diastolic}}</td>
                            <td>{{$specific_reading->pulse}}</td>
                            <td>{{ date('F d, Y H:i', strtotime($specific_reading->time))}}</td>
                            <td class="text-center"><button type="button" class="btn btn-<?php echo $systolic_status_class?> btn-sm rounded-pill" style="color: #fff">{{$specific_reading->systolic_status}}</button></td>
                            <td class="text-center"><button type="button" class="btn btn-<?php echo $diastolic_status_class?> btn-sm rounded-pill" style="color: #fff">{{$specific_reading->diastolic_status}}</button></td>
                            <td>
                                @if( auth()->user()->roles[0]->slug === 'super-admin' || auth()->user()->roles[0]->slug === 'nurse')
                                    <!-- <button class="btn btn-danger btn-sm"><i class="fas fa-ban text-white"></i></button> -->
                                    <a href="" title="Invalidate Reading" title="Invalidate Reading"><i class="fas fa-ban text-danger"></i></a>
                                @endif

                                @if( auth()->user()->roles[0]->slug === 'physician' || auth()->user()->roles[0]->slug === 'nurse' || auth()->user()->roles[0]->slug === 'super-admin' )
                                    <a href="" class="" title="Add reading comment"><i class="fas fa-comments text-success"></i></a>
                                @endif
                                
                            </td>
                        </tr>
                        
                    </tbody>
                </table>

                <div id="invalidate-reading-bloc" style="">
                  @if( auth()->user()->roles[0]->slug === 'nurse' || auth()->user()->roles[0]->slug === 'super-admin' )
                    <hr>

                    <h4>Invalidate Reading</h4>

                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group required row mt-3">
                              <label for="patient_contacted" class="col-md-3 col-form-label">Was the Patient contacted?</label>
                              <div class="col-md-4 mt-2">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="patient_contacted" id="patient_contacted_yes" value="1" {{ old('patient_contacted') == '1' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="patient_contacted_yes">Yes</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="patient_contacted" id="patient_contacted_no" value="0" {{ old('patient_contacted') == '0' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="patient_contacted_no">No</label>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group row mt-3">
                              <label for="invalidate-reason" class="col-md-6 col-form-label">Reason to invalidate reading</label>
                              <div class="col-md-6">
                                  <select class="form-control" id="invalidate-reason" name="invalidate-reason">
                                    <option></option>
                                    @foreach ($invalidingReasongs as $item)
                                        @if( $item->_uid === $invalidate_reason_id )
                                            <option value="{{$item->_uid}}" selected {{ old('invalidate-reason') == $item->_uid ? 'selected' : '' }}>{{$item->reason}}</option>
                                        @else
                                            <option value="{{$item->_uid}}" {{ old('invalidate-reason') == $item->_uid ? 'selected' : '' }}>{{$item->reason}}</option>
                                        @endif
                                    @endforeach
                                  </select>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group row mt-3">
                              <label for="invalidate-reason-specific" class="col-md-6 col-form-label">Reason Specifics</label>
                              <div class="col-md-6">
                                <select class="form-control" id="invalidate-reason-specific" name="invalidate-reason-specific">
                                    <option></option>
                                  </select>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group row mt-3">
                              <label for="first_name" class="col-md-6 col-form-label">Actions Taken</label>
                              <div class="col-md-6">
                                  <select class="form-control">
                                  <option></option>
                                    @foreach ($invalidateActions as $item)
                                        @if( $item->_uid === $invalidate_reason_id )
                                            <option value="{{$item->_uid}}" selected {{ old('invalidate-reason') == $item->_uid ? 'selected' : '' }}>{{$item->action}}</option>
                                        @else
                                            <option value="{{$item->_uid}}" {{ old('invalidate-reason') == $item->_uid ? 'selected' : '' }}>{{$item->action}}</option>
                                        @endif
                                    @endforeach
                                  </select>
                              </div>
                          </div>
                      </div>
                      <!-- <div class="col-md-6">
                          <div class="form-group row mt-3">
                              <label for="first_name" class="col-md-6 col-form-label">Actions Taken</label>
                              <div class="col-md-4">
                                <select class="form-control">
                                    <option></option>
                                  </select>
                              </div>
                          </div>
                      </div> -->
                  </div>

                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group row mt-3">
                              <label for="first_name" class="col-md-3 col-form-label"></label>
                              <div class="col-md-9">
                                  <input type="checkbox" id="1w" name="physician_can_see_reason" value="yes" >
                                  <label for="yes">Physician can see reason</label>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-2">
                          <button class="btn btn-success">Save</button>
                      </div>
                    </div>
                  @endif
                </div>
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
<script src="{{asset('vendors/chart.js/js/chart.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


<script>
  $(document).ready(function(){

  });

  $('#invalidate-reason').change(function(){
        let reasonId = $(this).val();

        $.ajax({
            url: '/<?php echo $role_slug?>/get-invalidating-reason-specifics/',
            type: 'POST',
            data: {
                _reason_id: reasonId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
            //console.log( JSON.parse( JSON.stringify(response)));
            if( response.success ){
              
            var select = $('#invalidate-reason-specific');
                    select.empty();

                    select.append($('<option>', { 
                        value: '',
                        text : '',
                        selected: true,
                        disabled: true
                    }));

                    $.each(response.data, function(index, item) {
                        select.append($('<option>', { 
                            value: item.id,
                            text : item.reason_details
                        }));
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle any errors here
                console.log(error);
            }
        });
    });
</script>

@endsection