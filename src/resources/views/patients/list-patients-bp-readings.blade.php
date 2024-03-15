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
                <div class="card-header"><h4>
                  <?php echo ($patient_name === null) ? 'My' : $patient_name ."'s" ?> BP Readings ::: Adherence Rate: <?php echo $adherenceRate?> ::: LOC: <?php echo $levelOfControlStatus?>
                  </h4>
                </div>
                <div class="card-body">

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

                
                
                
                <div class="c-chart-wrapper mb-5" style="position: relative; height:350px;margin-top:40px;">
                  <div class="row">
                    <div class="col-md-4"><h4>Patient's Readings for last <span id="time-period">{{$time_period}}</span></h4></div>
                    <div class="col-md-4 text-center"><h5>1st Week's Avg: <span id="time-period">{{number_format($firstWkBPAvg[0]->average_systolic,0)}}/{{number_format($firstWkBPAvg[0]->average_diastolic,0)}}</span></h5></div>
                    <div class="col-md-4 text-center"><h5>Avg <span id="average-bp-reading-text">{{$average_bp_reading_text}}</span> BP reading: <span id="average-bp-reading">{{$average_bp_reading}}</span></h5></div>
                  </div>
                    <canvas class="chart" id="main-chart" ></canvas>
                    
                </div>

                <!-- <form method="post" action="{{route($role_slug.'/update-patients-bp-graph', ['id' => $id])}}">
                  @csrf -->

                  <div class="container">
                    <div class="row justify-content-center mb-5">
                      <div class="col-auto">
                        <input type="radio" id="1w" name="time_period" value="1w" onchange="updateGraph(this.value)">
                        <label for="1w">1W</label>
                      </div>
                      <div class="col-auto">
                        <input type="radio" id="mtd" name="time_period" value="mtd" onchange="updateGraph(this.value)">
                        <label for="mtd">MTD</label>
                      </div>
                      <div class="col-auto">
                        <input type="radio" id="1m" name="time_period" value="1m" onchange="updateGraph(this.value)">
                        <label for="1m">1M</label>
                      </div>
                    </div>
                  </div>


                <!-- </form> -->

                

                <!-- <div class="" id="main-chart2" ></div> -->
                
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
                                <td class="text-center"><button type="button" class="btn btn-<?php echo $systolic_status_class?> btn-sm rounded-pill" style="color: #fff">{{$item->systolic_status}}</button></td>
                                <td class="text-center"><button type="button" class="btn btn-<?php echo $diastolic_status_class?> btn-sm rounded-pill" style="color: #fff">{{$item->diastolic_status}}</button></td>
                                <td>
                                    @if( auth()->user()->roles[0]->slug === 'physician' || auth()->user()->roles[0]->slug === 'nurse' || auth()->user()->roles[0]->slug === 'super-admin' )
                                        <a href="{{route('physician/patients-reading-details', ['id' => $item->_patientID, 'rID' => $item->_readingID])}}" class="" title="Reading details"><i class="fas fa-info-circle text-info"></i></a>
                                    @endif
                                    @if( auth()->user()->roles[0]->slug === 'physician' || auth()->user()->roles[0]->slug === 'nurse' || auth()->user()->roles[0]->slug === 'super-admin' )
                                        <a href="{{route('physician/patients-reading-details', ['id' => $item->_patientID, 'rID' => $item->_readingID])}}" class="" title="Add reading comment"><i class="fas fa-comments text-success"></i></a>
                                    @endif
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
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script>
//$(document).ready( function () {
    let tblReadings = $('#tableData').DataTable({
        "pageLength": 50,
        dom: 'Bfrtip',
        "ordering": false
    });

    var mainChart;

 mainChart = new Chart(document.getElementById('main-chart'), {
  type: 'line',
  data: {
    labels: [<?php echo $days?>],
    datasets: [{
      label: 'Systolic',
      //backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--cui-info'), 10),
      borderColor: coreui.Utils.getStyle('--cui-info'),
      //pointHoverBackgroundColor: '#fff',
      pointBackgroundColor: [<?php echo $systolic_fill_colours?>],
      borderWidth: 2,
      data: [<?php echo $systolic_points?>],
      fill: false
    },
    {
      label: 'Diastolic',
      borderColor: coreui.Utils.getStyle('--cui-success'),
      //pointHoverBackgroundColor: '#fff',
      pointBackgroundColor: [<?php echo $diastolic_fill_colours?>],
      borderWidth: 2,
      data: [<?php echo $diastolic_points?>]
    },
  ]
  },
  options: {
    maintainAspectRatio: false,
    responsive: true,
    plugins: {
      legend: {
        display: true
      }
    },
    scales: {
      x: {
        //type: 'linear',
        display: true,
        position: 'left',
        grid: {
          drawOnChartArea: true
        }
      },
      y: {
        //type: 'linear',
        display: true,
        ticks: {
          beginAtZero: true,
          maxTicksLimit: 5,
          stepSize: Math.ceil(250 / 5),
          max: 250
        }
      }
    },
    elements: {
      line: {
        tension: 0
      },
      point: {
        radius: 5,
        hitRadius: 10,
        hoverRadius: 4,
        hoverBorderWidth: 3
      }
    }
  }
});

function updateGraph(option) {
    $.ajax({
        url: '/<?php echo $role_slug?>/update-patients-bp-graph/<?php echo $id?>',
        type: 'POST',
        data: {
            option: option,
            _token: "{{ csrf_token() }}" // Laravel CSRF token
        },
        success: function(data) {
          //console.log( JSON.parse( JSON.stringify(data)));
          var days = data.days.split(',').map(function(date) {
              return date.trim().replace(/'/g, ''); // Remove single quotes and trim whitespace
          });
          var systolicValues = data.systolic_values.split(',').map(Number);
          var diastolicValues = data.diastolic_values.split(',').map(Number);
          var systolicFillColours = data.systolic_fill_colours.split(',').map(function(color) {
        return color.trim().replace(/'/g, '');
      });
          var diastolicFillColours = data.diastolic_fill_colours.split(',').map(function(color) {
        return color.trim().replace(/'/g, '');
      });

          // console.log('sfc: ' + systolicFillColours);
          // console.log('dfc: ' + diastolicFillColours);
          // console.log('sv: ' + systolicValues);
          // console.log('dv: ' + diastolicValues);
          // console.log('d: ' + days);

          mainChart.data.labels = days;
          mainChart.data.datasets[0].data = systolicValues;
          mainChart.data.datasets[0].pointBackgroundColor = systolicFillColours;
          mainChart.data.datasets[1].data = diastolicValues;
          mainChart.data.datasets[1].pointBackgroundColor = diastolicFillColours;

          // Update the chart
          mainChart.update();

          //console.log(mainChart.data);

          updateTable(data.readings);

          $('#average-bp-reading').text(data.average_bp_reading);
          $('#average-bp-reading-text').text(data.average_bp_reading_text);
          $('#time-period').text(data.no_of_days);

        },
        error: function(xhr, status, error) {
            // Handle any errors here
            console.error(error);
        }
    });
}

function updateTable(data)
{
  if(data !== null)
  {
    var transformedData = transformData(data);

    tblReadings.clear().draw(); // Clear the table
    tblReadings.rows.add(transformedData).draw();
  }
}

function formatDate(dateString) {
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const date = new Date(dateString);
    const formattedDate = `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()} ${date.getHours()}:${date.getMinutes().toString().padStart(2, '0')}`;
    return formattedDate;
}

function transformData(data) {
    return data.map(item => {
        let reading = item.systolic + '/' + item.diastolic;
        let formattedTime = formatDate(item.time); // Format the time
        let systolicStatusClass = getClassBasedOnStatus(item.systolic_status_id);
        let diastolicStatusClass = getClassBasedOnStatus(item.diastolic_status_id);

        return [
            reading,                 // Systolic/Diastolic
            item.pulse,              // Pulse
            formattedTime,           // Formatted Time
            '<center><button type="button" class="btn btn-' + systolicStatusClass + ' btn-sm rounded-pill">' + item.systolic_status + '</button></center>', // Systolic Status
            '<center><button type="button" class="btn btn-' + diastolicStatusClass + ' btn-sm rounded-pill">' + item.diastolic_status + '</button></center>', // Diastolic Status
            ''
        ];
    });
}

function getClassBasedOnStatus(statusId) {
    switch (statusId) {
        case 5:
            return "danger";
        case 4:
            return "warning";
        case 3:
            return "info";
        case 2:
            return "primary";
        case 1:
            return "secondary";
        default:
            return "";
    }
}
//} );

</script>

@endsection