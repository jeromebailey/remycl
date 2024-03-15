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
                   My BP Readings
                </div>
                <div class="card-body">
                
                <table class="table table-bordered table-striped" id="tableData">
                    <thead>
                        <tr>
                            <th>Reading</th>
                            <th>Pulse</th>
                            <!-- <th>Taken On</th> -->
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($readings as $item)
                            <tr>
                                <td>{{$item->systolic}}/{{$item->diastolic}}</td>
                                <td>{{$item->pulse}}</td>
                                <!-- <td>{{$item->pulse}}</td> -->
                                <td>
                                    <a href="" class=""><i class="fas fa-user-edit text-info"></i></a>
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
    
</script>

@endsection