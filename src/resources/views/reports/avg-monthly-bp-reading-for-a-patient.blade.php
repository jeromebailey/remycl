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
                </div>
                <div class="card-body">

                <form method="post" action="{{route($role_slug.'/reports/avg-monthly-bp-readings')}}">
                  @csrf

                  <div class="row">
                    <div class="col-md-3">
                        <select class="form-control" id="patient-name" name="patient-name">
                            <option>Select Patient Name</option>
                            @foreach ($patients as $item)
                                @if( $item->_patientID === $patient_id )
                                    <option value="{{$item->_patientID}}" selected {{ old('patient-name') == $item->_patientID ? 'selected' : '' }}>{{$item->first_name . ' ' . $item->last_name}}</option>
                                @else
                                    <option value="{{$item->_patientID}}" {{ old('patient-name') == $item->_patientID ? 'selected' : '' }}>{{$item->first_name . ' ' . $item->last_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <select class="form-control" id="year" name="year">
                            <option>Select Year</option>
                            @if( $yearsDDL !== null )
                                @foreach ($yearsDDL as $item)
                                    @if( $item->year === (int)$selected_year )
                                        <option value="{{$item->year}}" selected {{ old('year') == $item->year ? 'selected' : '' }}>{{$item->year}}</option>
                                    @else
                                        <option value="{{$item->year}}" {{ old('year') == $item->year ? 'selected' : '' }}>{{$item->year}}</option>
                                    @endif
                                @endforeach
                            @endif
                        
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-info">Submit</button>
                    </div>
                  </div>

                  @if( $graph_data !== null )
                    <h5>Average Monthly BP Readings</h5>
                    <div id="avg-monthly-bp-readings"></div>
                   @endif

                    <table class="table table-bordered table-striped mt-5" id="tableData">
                        <thead>
                            <tr>
                                <th>Systolic</th>
                                <th>Diastolic</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( $records !== null )
                            @foreach ($records as $item)
                                
                                <tr>
                                    <td>{{$item->average_systolic == '0.000' ? 0 : number_format($item->average_systolic, 0)}}</td>
                                    <td>{{$item->average_diastolic == '0.000' ? 0 : number_format($item->average_diastolic, 0)}}</td>
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
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
<script src="{{asset('vendors/chart.js/js/chart.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src='https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js' ></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script>

    let tblReadings = $('#tableData').DataTable({
        "pageLength": 50,
        dom: 'Bfrtip',
        "ordering": false
    });

    <?php if (!empty($graph_data)): ?>
    Morris.Bar({
        element: 'avg-monthly-bp-readings',
        data: [
            <?php echo $graph_data?>
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Systolic Avg', 'Diastolic Avg']
    });
    <?php endif; ?>

    $('#patient-name').change(function(){
        let patientId = $(this).val();

        $.ajax({
            url: '/<?php echo $role_slug?>/get-years-from-patient-data/',
            type: 'POST',
            data: {
                _patient_id: patientId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
            //console.log( JSON.parse( JSON.stringify(response)));
            if( response.success ){
            var select = $('#year');
                    select.empty(); 

                    select.append($('<option>', { 
                        value: '',
                        text : 'Select Year',
                        selected: true,
                        disabled: true
                    }));

                    $.each(response.data, function(index, item) {
                        select.append($('<option>', { 
                            value: item.year,
                            text : item.year
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