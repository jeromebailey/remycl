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
                   Device Stock Items
                </div>
                <div class="card-body">
                    <div class="row mb-3 pl-2">
                        <div class="col-md-2 offset-md-10" style="text-align: right;">
                            <button class="btn btn-light"><i class="fas fa-user-plus text-info"></i> Add Device</button>
                        </div>
                    </div>
                
                    <table class="table table-bordered table-striped" id="tableData">
                        <thead>
                            <tr class="text-center">
                                <th>Device Name</th>
                                <th>Manufacturer</th>
                                <th>Model No</th>
                                <th>Cost</th>
                                <th>Stock Amount</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stock as $item)
                                <tr>
                                    <td>{{$item->device_type_name}}</td>
                                    <td>{{$item->manufacturer_name}}</td>
                                    <td class="text-center">{{$item->model_no}}</td>
                                    <td class="text-right">{{$item->cost}}</td>
                                    <td class="text-right">{{$item->total}}</td>
                                    <td>
                                        @can('view-device-details')
                                            <a href="{{route('admin/device-details', $item->_uid)}}" class="" title="View Device Details"><i class="fas fa-file-alt text-secondary"></i></a> |
                                        @endcan

                                        @can('edit-device-details')
                                            <a href="" class="" title="Edit Device Details"><i class="fas fa-edit text-info"></i></a> |
                                        @endcan

                                        @can('delete-a-device')
                                            <a href="" class="" title="Delete Device"><i class="fas fa-trash-alt text-danger"></i></a>
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
<script src="{{ asset('js/app.js') }}" ></script>


@endsection