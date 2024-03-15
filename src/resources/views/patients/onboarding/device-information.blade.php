@if( empty($assigned_device) )

    <div id="no-assigned-device">
        <p>No device has been assigned.
            <button class="btn btn-sm btn-info" id="btnNoDeviceAssigned" type="button">Assign Device to Patient</button>
        </p>
    </div>

    <div id="assign-a-device" style="display: none;">
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <form method="post" id="frmAssignDevice" action="{{route($role_slug .'/assign-bp-device-to-patient', ['id' => $id])}}">
            @csrf
            <!-- @include('patients.onboarding.patient-information') -->
        </form>
    </div>
    
@else

    <div id="device-assigned">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row mt-3">
                    <label for="dob" class="col-md-2 col-form-label">Assigned Device:</label>
                    <div class="col-md-10 mt-2">
                        <?php echo "A <strong>".$assigned_device[0]->device_type_name ."</strong> has been assigned with IMEI: <strong>". $assigned_device[0]->device_unique_id."</strong>."?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endif

<script>
    let noDeviceButton = document.getElementById('btnNoDeviceAssigned');

    $('#btnNoDeviceAssigned').click(function(){
        let doAssign = confirm('Are you sure you want to assign a device to the patient?');

    if( doAssign ){
        // $('#assign-a-device').css('display', 'block');
        // $('#no-assigned-device').css('display', 'none');

        $('#frmAssignDevice')[0].submit();

        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        // $.ajax({
        //     url: '/<?php //echo $role_slug?>/assign-bp-device-to-patient/'.$id,
        //     type: 'POST',
        //     success: function(response){
        //         // handle success
        //         console.log('success: '+response);
        //     },
        //     error: function(xhr){
        //         // handle error
        //         console.log('error: '+xhr.responseText);
        //     }
        // });
    
    }
        
    });

</script>