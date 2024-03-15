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

                <form method="post" action="{{route($role_slug.'/reports/policies-expiring')}}">
                  @csrf

                  <div class="row">
                    <div class="col-md-1">
                        <select class="form-control" id="expires-in" name="expires-in">
                            <option value="" >Select Timeframe</option>
                                <option value="10" {{ $selected_days == 10 ? 'selected' : '' }}>10</option>
                                <option value="30" {{ $selected_days == 30 ? 'selected' : '' }}>30</option>
                                <option value="60" {{ $selected_days == 60 ? 'selected' : '' }}>60</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-info">Search</button>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-2 offset-md-10">
                        <button type="button" id="sendReminderBtn" class="btn btn-warning" style="display: none;">Send Reminder to Client(s)</button>
                    </div>
                  </div>

                    <table class="table table-bordered table-striped mt-5" id="tableData">
                        <thead class="table-light fw-semibold">
                        <tr class="align-middle">
                            <th><input type="checkbox" id="selectAll"/></th>
                            <th class="">
                            Policy No.
                            </th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th class="">Policy Type</th>
                            <th class="">Expires</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($records !== null && count($records) > 0)
                            @foreach($records as $row)
                            <tr class="align-middle">
                                <td><input type="checkbox" class="selectItem" value="<?php echo $row->id?>" name="client-id[]" /></td>
                                <td class="">
                                <a href="{{route('admin/client', ['id'=>$row->id])}}"><?php echo $row->policy_no?></a>
                                </td>
                                <td>
                                <div><?php echo $row->first_name?></div>
                                </td>
                                <td>
                                <div><?php echo $row->last_name?></div>
                                </td>
                                <td class=""><?php echo $row->policy_type?></td>
                                <td>
                                <?php echo date('F d, Y', strtotime($row->policy_expires_at))?>
                                </td>
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
$(document).ready(function() {
    // Toggle the "Send Reminder" button
    function toggleSendReminderButton() {
        var anyChecked = $('.selectItem:checked').length > 0;
        $('#sendReminderBtn').toggle(anyChecked);
    }

    // Select or Deselect All
    $('#selectAll').click(function() {
        $('.selectItem').prop('checked', this.checked);
        toggleSendReminderButton();
    });

    // Individual checkbox change
    $('.selectItem').change(function() {
        if (!this.checked) {
            $('#selectAll').prop('checked', false);
        }
        toggleSendReminderButton();
    });

    $("#sendReminderBtn").click(function(){
        var selectedClientIds = $('input[name="client-id[]"]:checked').map(function() {
            return this.value // Assuming Policy No. is unique and text-based
        }).get();

        var daysBeforeExpiration = $('#expires-in').val();

        $.ajax({
            url: '/<?php echo $role_slug?>/send-sms-to-clients-with-expiring-policies/', // Update this URL to your actual AJAX handler
            type: 'POST',
            data: { 
                clientIds: selectedClientIds,
                days: daysBeforeExpiration,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                //alert('Reminders sent successfully!');
                console.log(response.success);
                // Optionally, add more logic here for after the reminders are sent
            },
            error: function() {
                alert('Error sending reminders.');
            }
        });
    });
});
</script>

@endsection