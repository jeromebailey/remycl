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
                   My Patient's BP Readings
                </div>
                <div class="card-body">

                @include('errors.error-message')
                @include('success.success-message')

                <!-- <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                    <canvas class="chart" id="patients-bp-readings" height="300"></canvas>
                </div> -->
                
                <table class="table table-bordered table-striped" id="tableData">
                    <thead>
                        <tr>
                            <th>Patient's Name</th>
                            <th>Reading</th>
                            <th>Pulse</th>
                            <th>Taken On</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients_readings as $item)
                            <tr>
                                <td>
                                    <a href="{{route('physician/patients-bp-readings', ['id' => $item->_patientID])}}">
                                    {{$item->first_name}} {{$item->last_name}}
                                    </a>
                                </td>
                                <td>{{$item->systolic}}/{{$item->diastolic}}</td>
                                <td>{{$item->pulse}}</td>
                                <td>{{ date('F d, Y H:i', strtotime($item->time))}}</td>
                                <td>
                                    <a href="" class=""><i class="fas fa-user-edit text-info"></i></a>
                                    @if( auth()->user()->roles[0]->slug === 'physician' || auth()->user()->roles[0]->slug === 'nurse' || auth()->user()->roles[0]->slug === 'super-admin' )
                                        <a href="{{route('physician/patients-reading-details', ['id' => $item->_patientID, 'rID' => $item->_readingID])}}" class=""><i class="fas fa-heartbeat text-info"></i></a>
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

    const patientsBPReadingsChart = new Chart(document.getElementById('patients-bp-readings'), {
  type: 'line',
  data: {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [{
      label: 'Systolic',
      backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--cui-info'), 10),
      borderColor: coreui.Utils.getStyle('--cui-info'),
      pointHoverBackgroundColor: '#fff',
      borderWidth: 2,
      data: [random(100, 140), random(100, 140), random(100, 140), random(100, 140), random(100, 140), random(100, 140), random(100, 140)],
      fill: true
    },
    {
      label: 'Diastolic',
      borderColor: coreui.Utils.getStyle('--cui-success'),
      pointHoverBackgroundColor: '#fff',
      borderWidth: 2,
      data: [random(40, 90), random(40, 90), random(40, 90), random(40, 90), random(40, 90), random(40, 90), random(40, 90)]
    },
    {
      label: 'Systolic Border top',
      borderColor: coreui.Utils.getStyle('--cui-warning'),
      pointHoverBackgroundColor: '#fff',
      borderWidth: 1,
      borderDash: [8, 5],
      data: [160, 160, 160, 160, 160, 160, 160]
    },
    {
      label: 'Systolic Border bottom',
      borderColor: coreui.Utils.getStyle('--cui-warning'),
      pointHoverBackgroundColor: '#fff',
      borderWidth: 1,
      borderDash: [8, 5],
      data: [140, 140, 140, 140, 140, 140, 140]
    },
    {
      label: 'Diastolic Border top',
      borderColor: coreui.Utils.getStyle('--cui-danger'),
      pointHoverBackgroundColor: '#fff',
      borderWidth: 1,
      borderDash: [8, 5],
      data: [90, 90, 90, 90, 90, 90, 90]
    },
    {
      label: 'Diastolic Border bottom',
      borderColor: coreui.Utils.getStyle('--cui-danger'),
      pointHoverBackgroundColor: '#fff',
      borderWidth: 1,
      borderDash: [8, 5],
      data: [60, 60, 60, 60, 60, 60, 60]
    }]
  },
  options: {
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false
      }
    },
    scales: {
      x: {
        grid: {
          drawOnChartArea: false
        }
      },
      y: {
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
        tension: 0.4
      },
      point: {
        radius: 0,
        hitRadius: 10,
        hoverRadius: 4,
        hoverBorderWidth: 3
      }
    }
}
});
    
</script>

@endsection