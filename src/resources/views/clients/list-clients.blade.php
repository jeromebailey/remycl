@extends('layouts.main')

@section('head-links')
  @include('layouts.common.meta-data')
  <title>{{ config('app.name', 'Laravel') }}</title>
  @include('layouts.common.css-links')
  <link rel="stylesheet" href='https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css' />
@stop

@section('content')

 @include('errors.error-message')
    @include('success.success-message')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                   All Clients
                </div>
                <div class="card-body">

                    @if( auth()->user()->roles[0]->slug === 'super-admin' && auth()->user()->can('add-client') )
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-warning" id="bulkActionBtn" disabled><i class="fas fa-cogs"></i> Send SMS(s)</button>
                            <button class="btn btn-danger" style="margin-left: 1rem; color: #fff" data-toggle="modal" data-target="#delete-all-clients"><i class="fas fa-user-minus text-white"></i> Delete Client Data </button>
                            <button class="btn btn-light" style="margin-left: 1rem" data-toggle="modal" data-target="#onboard-client"><i class="fas fa-user-plus text-info"></i> Add Client</button>
                        </div>
                    @endif
                
                <table class="table table-bordered table-striped" id="tableData">
                    <thead>
                        <tr>
                            <th class=""><input type="checkbox" id="selectAll" title="Select All"></th>
                            <th class="">Policy No.</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th class="">Policy Type</th>
                            <th class="">Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td class="">
                                    <input type="checkbox" class="client-checkbox" value="{{$client->_clientID}}" data-client-name="{{$client->first_name}} {{$client->last_name}}">
                                </td>
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
                                <td class=""><?php echo $client->policy_status?></td>
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

    <!-- Delete All Clients Modal -->
    <div class="modal fade" id="delete-all-clients" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete All Client Data</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Warning!</strong> This action will permanently delete all your client data and cannot be undone.
                    </div>
                    <p>Are you sure you want to delete all your clients?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route($role_slug . '/clients.deleteAll') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes, Delete All</button>
                    </form>
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

    <!-- Bulk Action Modal -->
    <div class="modal fade" id="bulkActionModal" tabindex="-1" role="dialog" aria-labelledby="bulkActionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkActionModalLabel">Bulk Actions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="selectedClientsInfo"><strong>Selected Clients (<span id="selectedCount">0</span>):</strong></label>
                        <div id="selectedClientsInfo" class="border rounded p-3 mb-3" style="max-height: 150px; overflow-y: auto; background-color: #ffffff;">
                            <!-- Selected clients will be displayed here -->
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="bulkAction"><strong>Select Action:</strong></label>
                        <select class="form-control" id="bulkAction" name="action">
                            <option value="">-- Choose Action --</option>
                            <option value="send_sms">Send SMS (Lapse Pending)</option>
                            <option value="export">Export Selected</option>
                            <option value="update_status">Update Status</option>
                        </select>
                    </div>
                    
                    <!-- SMS Preview Section (Initially Hidden) -->
                    <div id="smsPreviewSection" class="form-group" style="display: none;">
                        <label><strong>SMS Template Preview:</strong></label>
                        <div class="alert alert-info">
                            <small class="text-muted">Template: <strong>lapse-pending</strong></small>
                            <div id="smsTemplatePreview" class="mt-2">
                                <!-- Template content will be loaded here -->
                            </div>
                        </div>
                        <p class="text-muted"><small>Note: Placeholders like [first_name], [policy_type], [policy_no], [expiry_date] will be replaced with actual client data.</small></p>
                    </div>
                    
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="confirmAction">
                            <label class="custom-control-label" id="confirmActionLabel" for="confirmAction">
                                I confirm that I want to perform this action on <span id="confirmCount">0</span> client(s)
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmBulkAction" disabled>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span id="actionButtonText">Execute Action</span>
                    </button>
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

    $('#selectAll').on('change', function() {
        var isChecked = $(this).is(':checked');
        $('.client-checkbox').prop('checked', isChecked);
        toggleBulkActionButton();
    });
    
    // Handle individual checkbox changes
    $(document).on('change', '.client-checkbox', function() {
        var totalCheckboxes = $('.client-checkbox').length;
        var checkedCheckboxes = $('.client-checkbox:checked').length;
        
        // Update "Select All" checkbox state
        if (checkedCheckboxes === totalCheckboxes) {
            $('#selectAll').prop('checked', true).prop('indeterminate', false);
        } else if (checkedCheckboxes === 0) {
            $('#selectAll').prop('checked', false).prop('indeterminate', false);
        } else {
            $('#selectAll').prop('checked', false).prop('indeterminate', true);
        }
        
        toggleBulkActionButton();
    });
    
    // Function to enable/disable bulk action button
    function toggleBulkActionButton() {
        var checkedCheckboxes = $('.client-checkbox:checked').length;
        $('#bulkActionBtn').prop('disabled', checkedCheckboxes === 0);
    }
    
    // Handle bulk action button click
    $('#bulkActionBtn').click(function() {
        var selectedClients = [];
        $('.client-checkbox:checked').each(function() {
            //console.log('id: ' + $(this).val());
            selectedClients.push({
                id: $(this).val(),
                name: $(this).data('client-name')
            });
        });
        
        if (selectedClients.length > 0) {
            // You can customize this action as needed
            // alert('Selected ' + selectedClients.length + ' client(s) for bulk action');
            // console.log('Selected clients:', selectedClients);

            populateBulkActionModal(selectedClients);
            $('#bulkActionModal').modal('show');
            
            // Example: You could open a modal here or perform bulk operations
            // performBulkAction(selectedClients);
        }
    });

    // Function to populate bulk action modal
    function populateBulkActionModal(clients) {
        var clientsHtml = '';
        clients.forEach(function(client, index) {
            clientsHtml += '<span class="badge badge-primary mr-2 mb-2" style="font-size: 12px; padding: 6px 10px; color:#000">' + client.name + '</span>';
        });
        
        $('#selectedClientsInfo').html(clientsHtml);
        $('#selectedCount').text(clients.length);
        $('#confirmCount').text(clients.length);
        
        // Reset form
        $('#bulkAction').val('');
        $('#confirmAction').prop('checked', false);
        $('#confirmBulkAction').prop('disabled', true);
        $('#smsPreviewSection').hide();
        $('#actionButtonText').text('Execute Action');
    }

    // Handle action selection change
    $('#bulkAction').on('change', function() {
        var selectedAction = $(this).val();
        
        if (selectedAction === 'send_sms') {
            loadSmsTemplate();
            $('#smsPreviewSection').show();
            $('#actionButtonText').text('Send SMS');
        } else {
            $('#smsPreviewSection').hide();
            $('#actionButtonText').text('Execute Action');
        }
        
        updateActionButtonState();
    });
    
    // Load SMS template preview
    function loadSmsTemplate() {
        $.ajax({
            url: "/<?php echo $role_slug?>/get-sms-template", 
            type: "GET",
            data: {
                _token: "{{ csrf_token() }}",
                status: "policy-expiring-no-date"
            },
            success: function(response) {
                if (response.success && response.template) {
                    $('#smsTemplatePreview').html('<strong>Preview:</strong><br>' + response.template.template_body);
                } else {
                    $('#smsTemplatePreview').html('<span class="text-danger">Template not found</span>');
                }
            },
            error: function(xhr, status, error) {
                $('#smsTemplatePreview').html('<span class="text-danger">Error loading template</span>');
            }
        });
    }
    
    // Handle confirmation checkbox
    $('#confirmAction').on('change', function() {
        updateActionButtonState();
    });
    
    // Update action button state
    function updateActionButtonState() {
        var actionSelected = $('#bulkAction').val() !== '';
        var isConfirmed = $('#confirmAction').is(':checked');
        var isValid = actionSelected && isConfirmed;
        
        $('#confirmBulkAction').prop('disabled', !isValid);
    }
    
    // Handle bulk action execution
    $('#confirmBulkAction').click(function() {
        var selectedClients = [];
        $('.client-checkbox:checked').each(function() {
            selectedClients.push($(this).val());
        });
        
        var selectedAction = $('#bulkAction').val();
        var button = $(this);
        var spinner = button.find('.spinner-border');
        
        // Show loading state
        button.prop('disabled', true);
        spinner.removeClass('d-none');
        $('#actionButtonText').text('Processing...');
        
        // Execute the selected action
        if (selectedAction === 'send_sms') {
            executeSmsAction(selectedClients, button, spinner);
        } else if (selectedAction === 'export') {
            executeExportAction(selectedClients, button, spinner);
        } else if (selectedAction === 'update_status') {
            executeUpdateStatusAction(selectedClients, button, spinner);
        }
    });
    
    // Execute SMS action
    function executeSmsAction(clientIds, button, spinner) {
        $.ajax({
            url: "/<?php echo $role_slug?>/send-bulk-lapse-sms",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                client_ids: clientIds
            },
            success: function(response) {
                console.log('message: ' + JSON.stringify(response.message));
                if (response.success === true) {
                    alert('SMS sent successfully to ' + response.successful_count + ' client(s)!');
                    if (response.failed_count > 0) {
                        alert('Note: ' + response.failed_count + ' SMS(s) failed to send. Check the logs for details.');
                    }
                    $('#bulkActionModal').modal('hide');
                    
                    // Optionally uncheck all checkboxes
                    $('.client-checkbox').prop('checked', false);
                    $('#selectAll').prop('checked', false);
                    toggleBulkActionButton();
                } else {
                    alert('Error: ' + (response.message || 'Failed to send SMS. Please try again.'));
                }
            },
            error: function(xhr, status, error) {
                var errorMessage = 'An error occurred while sending SMS.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            },
            complete: function() {
                resetActionButton(button, spinner);
            }
        });
    }
    
    // Execute export action (placeholder)
    function executeExportAction(clientIds, button, spinner) {
        // Implement export functionality
        setTimeout(function() {
            alert('Export functionality would be implemented here');
            $('#bulkActionModal').modal('hide');
            resetActionButton(button, spinner);
        }, 1000);
    }
    
    // Execute update status action (placeholder)
    function executeUpdateStatusAction(clientIds, button, spinner) {
        // Implement status update functionality
        setTimeout(function() {
            alert('Status update functionality would be implemented here');
            $('#bulkActionModal').modal('hide');
            resetActionButton(button, spinner);
        }, 1000);
    }
    
    // Reset action button to original state
    function resetActionButton(button, spinner) {
        button.prop('disabled', false);
        spinner.addClass('d-none');
        $('#actionButtonText').text('Execute Action');
        updateActionButtonState();
    }

});

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