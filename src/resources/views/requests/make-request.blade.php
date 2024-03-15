@extends('layouts.main')

@section('head-links')
  @include('layouts.common.meta-data')
  <title>{{ config('app.name', 'Laravel') }}</title>
  @include('layouts.common.css-links')
@stop

@section('content')
    @include('daysallotment.days_allotment_summary')

    <div class="row">
        <div class="col-md-8">
            <form action="{{route('store-leave-request')}}" method="post">
                <div class="card mb-4">
                    <div class="card-header">Leave Request Form</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="employee_id">Employee ID</label>
                            <input type="text" class="form-control" id="employee_id" name="employee_id" autocomplete="off" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="employee_name">Employee Name</label>
                            <input type="text" class="form-control" id="employee_name" name="employee_name" autocomplete="off" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="leave_type">Leave Type</label>
                            <select id="leave_type" name="leave_type" class="form-control" required>
                            <option value="">Select Leave Type</option>
                                @foreach ($leave_types as $item)
                                    <option value="{{$item->_uid}}">{{$item->leave_type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" autocomplete="off" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" autocomplete="off" required>
                        </div>

                        <div class="form-group mt-2">
                            <label for="reason">Reason for Leave</label>
                            <textarea class="form-control" id="reason" name="reason"></textarea>
                        </div>

                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary rounded-pill">Submit</button>
                        </div>
                        
                        
                    </div>
                </div>
                @csrf
                
            </form>
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