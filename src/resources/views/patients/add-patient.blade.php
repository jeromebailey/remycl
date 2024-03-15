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
                   All Patients
                </div>
                <div class="card-body">
                <table class="table table-bordered table-striped" id="tableData">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $patient)
                            <tr>
                                <td>{{$patient->first_name}}</td>
                                <td>{{$patient->last_name}}</td>
                                <td>{{$patient->email}}</td>
                                <td>
                                    <a href="" class=""><i class="fas fa-user-edit text-info"></i></a>
                                    <a href="" class=""><i class="fas fa-trash-alt text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- /.row-->
    @endsection

@section('scripts')
@include('layouts.common.scripts')
<script src="{{ asset('js/app.js') }}" ></script>
<script>

    
</script>

@endsection