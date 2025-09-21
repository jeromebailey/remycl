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
                   All Patients
                </div>
                <div class="card-body">
                    <ol style="column-count: 3;">
                        
                        @if( auth()->user()->roles[0]->slug === 'super-admin' )
                            <li><a href="{{route($role_slug.'/reports/all-clients')}}">All Clients</a></li>
                        @endif
                        @if( auth()->user()->roles[0]->slug === 'super-admin' )
                            <li><a href="{{route($role_slug.'/reports/sms-sent-by-agent')}}">SMS Sent by an Agent</a></li>
                        @endif
                        @if( auth()->user()->roles[0]->slug === 'super-admin' )
                            <li><a href="{{route($role_slug.'/reports/expired-policies')}}">Expired Policies</a></li>
                        @endif
                        @if( auth()->user()->roles[0]->slug === 'super-admin' )
                            <li><a href="{{route($role_slug.'/reports/policies-expiring')}}">Policies Expiring</a></li>
                        @endif
                        @if( auth()->user()->roles[0]->slug === 'super-admin' )
                            <li><a href="{{route($role_slug.'/reports/policies-expiring')}}">Find Premium Payments</a></li>
                        @endif
                    </ol>
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