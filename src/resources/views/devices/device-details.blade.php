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
                   Device Details
                </div>
                <div class="card-body">
                
                    <p><strong>Device Name</strong>: {{ $device_details->device_name }}</p>
                    <p><strong>Model No</strong>: {{ $device_details->model_no }}</p>
                    <p><strong>Device Manufacturer</strong>: {{ $device_details->manufacturer_name }}</p>
                    <p><strong>Description</strong>: {{ $device_details->description }}</p>
                    <p><strong>Device Material</strong>: 
                        <a href="">User Manual</a> <br>
                    </p>
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


