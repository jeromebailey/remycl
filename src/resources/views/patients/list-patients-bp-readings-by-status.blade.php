@extends('layouts.main')

@section('head-links')
  @include('layouts.common.meta-data')
  <title>{{ config('app.name', 'Laravel') }}</title>
  @include('layouts.common.css-links')
  <link rel="stylesheet" href='https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css' />
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                <?php echo ($patient_name === null) ? 'My' : $patient_name ."'s" ?> BP Readings
                </div>
                <div class="card-body">

                <div class="row">
      <div class="col-sm-6 col-lg-3">
        <div class="card mb-4 text-white bg-primary">
          <div class="card-body pb-0 d-flex justify-content-between align-items-start">
            <div>
              <div class="fs-4 fw-semibold"><a class="bp-status-links" href="{{route('physician/patients-bp-readings-by-status', ['id' => $id, 'statusId' => $low_uuid])}}" class=""><?php echo $low_readings?> </a>
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
              <div class="fs-4 fw-semibold"><a class="bp-status-links" href="{{route('physician/patients-bp-readings-by-status', ['id' => $id, 'statusId' => $high_uuid])}}" class=""><?php echo $high_readings?></a> <span class="fs-6 fw-normal"></div>
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
                        @foreach ($readings as $item)
                            @php
                                $systolic_status_class = $diastolic_status_class = "";
                                switch($item->systolic_status_id)
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

                                switch($item->diastolic_status_id)
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
                                <td>{{$item->systolic}}/{{$item->diastolic}}</td>
                                <td>{{$item->pulse}}</td>
                                <td>{{ date('F d, Y H:i', strtotime($item->time))}}</td>
                                <td class="text-center"><button type="button" class="btn btn-<?php echo $systolic_status_class?> btn-sm rounded-pill">{{$item->systolic_status}}</button></td>
                                <td class="text-center"><button type="button" class="btn btn-<?php echo $diastolic_status_class?> btn-sm rounded-pill">{{$item->diastolic_status}}</button></td>
                                <td>
                                    @if( auth()->user()->roles[0]->slug === 'super-admin')
                                        <a href="" class=""><i class="fas fa-trash-alt text-danger"></i></a>
                                    @endif
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
<script src='https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js' ></script>
<script>
$(document).ready( function () {
    $('#tableData').DataTable({
        "pageLength": 50,
        dom: 'Bfrtip',
        "ordering": false
    });
} );
    
</script>

@endsection