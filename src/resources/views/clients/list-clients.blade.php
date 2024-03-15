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
                   All Clients
                </div>
                <div class="card-body">
                    @if( auth()->user()->roles[0]->slug === 'physician' && auth()->user()->can('sign-up-client'))
                        <div class="row mb-3 pl-2">
                            <div class="col-md-2 offset-md-10" style="text-align: right;">
                                <button class="btn btn-light" data-toggle="modal" data-target="#sign-up-client"><i class="fas fa-user-plus text-info"></i> Sign-up Client</button>
                            </div>
                        </div>
                    @endif

                    @if( auth()->user()->roles[0]->slug === 'super-admin' && auth()->user()->can('add-client') || auth()->user()->roles[0]->slug === 'nurse' && auth()->user()->can('add-client') )
                        <div class="row mb-3 pl-2">
                            <div class="col-md-2 offset-md-10" style="text-align: right;">
                                <button class="btn btn-light" data-toggle="modal" data-target="#onboard-client"><i class="fas fa-user-plus text-info"></i> Add Client</button>
                            </div>
                        </div>

                        @include('clients.onboarding.client-holder')
                    @endif
                
                <table class="table table-bordered table-striped" id="tableData">
                    <thead>
                        <tr>
                        <th class="">
                      Policy No.
                    </th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th class="">Policy Type</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                            <td class="">
                          <a href="{{route($role_slug.'/client', ['id'=>$client->_clientID])}}"><?php echo $client->policy_no?></a>
                        </td>
                        <td>
                          <?php echo $client->first_name?>
                        </td>
                        <td>
                          <?php echo $client->last_name?>
                        </td>
                        <td class=""><?php echo $client->policy_type?></td>
                        <td>
                            @if(auth()->user()->can('add-client-payment'))
                            <?php
                            $path = '';
                            $role = auth()->user()->roles[0]->slug;
                            switch ($role) {
                                case 'super-admin':
                                    $path = 'admin';
                                    break;
                                    
                                case 'nurse':
                                    $path = 'nurse';
                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }
                            ?>
                                <a href="javascript:void(0);" onclick="openPaymentModal(this)" data-uuid="{{$client->_clientID}}" class="" title="Add Payment">
                                    <i class="fa fa-credit-card text-success" aria-hidden="true"></i>
                                </a>
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

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Add Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <input type="hidden" id="clientID" name="client_uuid" value="">
                <div class="modal-body">
                <div class="form-group">
                    <label for="clientName">Client's Name</label>
                    <input type="text" class="form-control" id="clientName" value="" placeholder="John Doe" disabled>
                </div>
                <div class="form-group">
                    <label for="paymentAmount">Amount Paid</label>
                    <input type="number" class="form-control" id="paymentAmount" name="amount" placeholder="Enter amount" required>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" id="btnCloseModal" onclick="closeModal()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" id="submitPayment">Submit Payment</button>
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

function openPaymentModal(element) {
    var clientID = $(element).data('uuid');
    var tr = $(element).closest('tr');
    var firstName = tr.find('td:nth-child(2)').text().trim();
    var lastName = tr.find('td:nth-child(3)').text().trim();

    // Set the values in the modal.
    $('#paymentModal #clientName').val(firstName + ' ' + lastName);
    $('#paymentModal #clientID').val(clientID);

    $('#paymentModal').modal('show'); // Open the modal.
}

function closeModal(){
    $('#paymentModal').modal('hide');
}

$('#submitPayment').click(function() {
        var amount = $('#paymentAmount').val(); // Assuming this is your input's ID.
        var clientID = $('#clientID').val(); // Assuming you're keeping the client's UUID in a hidden input.

        // Validation: Amount should not be 0.
        if (amount <= 0) {
            alert('The amount must be greater than 0.'); // Use a more user-friendly message or method to display this.
            return; // Stop the function here.
        }

        // Proceed with AJAX if validation passes.
        $.ajax({
            url: "/<?php echo $role_slug?>/add-client-payment", // Your endpoint here.
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}", // Include CSRF token for Laravel.
                amount: amount,
                client_id: clientID, // Pass the client's UUID if necessary.
            },
            success: function(response) {
                // Handle success.
                if( response.success === true ){
                    alert('Payment added successfully.'); // Show a success message.
                    $('#paymentModal').modal('hide'); // Hide the modal.
                } else {
                    alert('Payment was not added. Please try again'); // Show a success message.
                    //$('#paymentModal').modal('hide'); // Hide the modal.
                }
               
                // Optionally, refresh the page or part of it to show updated data.
            },
            error: function(xhr, status, error) {
                // Handle errors.
                alert('An error occurred.'); // Show an error message.
            }
        });
    });
    
</script>

@endsection