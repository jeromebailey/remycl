@extends('layouts.main')

@section('head-links')
  @include('layouts.common.meta-data')
  <title>{{ config('app.name', 'Laravel') }}</title>
  @include('layouts.common.css-links')
@stop

@section('content')

    @include('errors.error-message')
    @include('success.success-message')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                   Import Clients
                </div>
                <div class="card-body">
                    <form method="post" action="{{route($role_slug .'/import-clients')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3 pl-2">
                            <div class="col-md-6">
                                <div class="form-group row mt-3">
                                    <label for="importFile" class="col-md-3 col-form-label">File to import</label>
                                    <div class="col-md-7">
                                        <input type="file" name="importFile" id="importFile" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 pl-2">
                            <div class="col-md-2">
                                <div class="form-group row mt-3">
                                    <button type="submit" id="btnUpload" class="btn btn-outline-primary" name="btnUpload" >Upload</button>
                                </div>
                            </div>
                        </div>

                    </form>
                    
                
                    
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