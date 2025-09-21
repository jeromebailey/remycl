@extends('layouts.main')

@section('head-links')
  @include('layouts.common.meta-data')
  <title>{{ config('app.name', 'Laravel') }}</title>
  @include('layouts.common.css-links')
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@stop

@section('content')

    
    <!-- /.row-->
    @if( auth()->user()->roles[0]->slug === 'super-admin' || auth()->user()->roles[0]->slug === 'sales-exec' )
    <div class="card mb-4">
    <div class="card-header">Expired Policies</div>
      <div class="card-body">
      <div class="table-responsive">
              <table class="table border table-striped mb-0">
                <thead class="table-light fw-semibold">
                  <tr class="align-middle">
                    <th class="">
                      Policy No.
                    </th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th class="">Policy Type</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @if(count($expired_policies) > 0)
                    @foreach($expired_policies as $row)
                      <tr class="align-middle">
                        <td class="">
                          <a href="{{route('admin/client', ['id'=>$row->id])}}"><?php echo $row->policy_no?></a>
                        </td>
                        <td>
                          <?php echo $row->first_name?>
                        </td>
                        <td>
                          <?php echo $row->last_name?>
                        </td>
                        <td class=""><?php echo $row->policy_type?></td>
                        <td>
                          <div class="dropdown">
                            <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <svg class="icon">
                                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
                              </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Send Text</a><a class="dropdown-item" href="#">Edit</a><a class="dropdown-item text-danger" href="#">Delete</a></div>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
      </div>
    </div>
@endif

    
    
    <!-- /.row-->
    
    <!-- /.row-->

    @endsection

@section('scripts')
<script src="{{ asset('js/app.js') }}" defer></script>

<script src="{{asset('vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script>
    <script src="{{asset('vendors/simplebar/js/simplebar.min.js')}}"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="{{asset('vendors/chart.js/js/chart.min.js')}}"></script>
    <script src="{{asset('vendors/@coreui/chartjs/js/coreui-chartjs.js')}}"></script>
    <script src="{{asset('vendors/@coreui/utils/js/coreui-utils.js')}}"></script>
    <!-- <script src="{{asset('js/main.js')}}"></script> -->
<script
			  src="https://code.jquery.com/jquery-3.7.0.min.js"
			  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
			  crossorigin="anonymous"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

@endsection