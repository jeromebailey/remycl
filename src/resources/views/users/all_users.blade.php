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
                    All Employees
                </div>
                <div class="card-body">
                    @can('add-health-e-user')
                        <div class="row mb-3 pl-2">
                            <div class="col-md-2 offset-md-10" style="text-align: right;">
                                <button class="btn btn-light"><i class="fas fa-user-plus text-info"></i> Add User</button>
                            </div>
                        </div>
                    @endcan

                    <table class="table table-bordered table-striped" id="tableData">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_users as $item)
                                <tr>
                                    <td>{{$item->first_name}}</td>
                                    <td>{{$item->last_name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->role_name}}</td>
                                    <td>
                                        @can('edit-health-e-user')
                                            <a href="" class=""><i class="fas fa-edit text-info"></i></a>
                                        @endcan

                                        @can('delete-health-e-user')
                                        <a href="" class=""><i class="fas fa-trash-alt text-danger"></i></a>
                                        @endcan
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