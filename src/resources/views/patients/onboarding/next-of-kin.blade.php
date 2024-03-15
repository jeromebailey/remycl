@if(empty($caregivers))

    <div id="no-caregivers">
        <p>No caregivers have been added.
            <button class="btn btn-sm btn-info" id="btnNoCaregiver" type="button">Add a Caregiver</button>
        </p>
    </div>

    @include('patients.onboarding.add-caregiver-form')

@else

    <div class="row mb-4">
        <div class="col-md-2">
            <button class="btn btn-sm btn-info" id="caregiverExists" type="button">Add a Caregiver</button>
        </div>
    </div>

    @include('patients.onboarding.add-caregiver-form')

    <div id="caregiversList">
        <table class="table table-bordered table-striped">
            <thead class="table-light fw-semibold">
                <tr class="align-middle">
                <th class="text-center">
                </th>
                <th>Caregiver's Name</th>
                <th class="text-center">Date of birth</th>
                <th>Gender</th>
                <th>Email</th>
                <th class="text-center">Primary</th>
                <th></th>
                </tr>
            </thead>
            <tbody>
                @if(count($caregivers) > 0)
                @foreach($caregivers as $row)
                    <tr class="align-middle">
                    <td class="text-center">
                        <div class="avatar avatar-md"><img class="avatar-img" src="{{asset('img/avatars/1.jpg')}}" alt="user@email.com"></div>
                    </td>
                    <td>
                        <?php echo $row->first_name . ' ' . $row->last_name?>
                    </td>
                    <td class="text-center">
                    <?php echo date('F d, Y', strtotime($row->dob))?>
                    </td>
                    <td>
                    <?php echo $row->gender?>
                    </td>
                    <td>
                        <?php echo $row->email?>
                    </td>
                    <td class="text-center">
                        <?php echo ($row->is_primary_caregiver == 0) ? 'No' : 'Yes'?>
                    </td>
                    
                    <td>
                        <div class="dropdown">
                        <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg class="icon">
                            <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" >
                            <a class="dropdown-item" href="#">Edit</a>
                            <a class="dropdown-item text-danger" href="#">Delete</a>
                        </div>
                        </div>
                    </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    

@endif

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
<script
src="https://code.jquery.com/jquery-3.7.0.min.js"
integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

<script src="{{asset('js/intlTelInput.min.js')}}"></script>

<script>
    $(document).ready(function(){

        let noDeviceButton = document.getElementById('btnNoCaregiver');

        $('#btnNoCaregiver').click(function(){
            let doAssign = confirm('Are you sure you want to add a caregiver for the patient?');

            if( doAssign ){
                $('#add-caregiver').css('display', 'block');
                $('#no-caregivers').css('display', 'none');
            }
        });

        $('#caregiverExists').click(function(){
            let doAssign = confirm('Are you sure you want to add a caregiver for the patient?');

            if( doAssign ){
                $('#add-caregiver').css('display', 'block');
                $('#caregiversList').css('display', 'none');
            }
        });

    $(".phone").each(function(){
        var iti = window.intlTelInput(this, {
            initialCountry: 'ky',
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        var errorMsg = $("#error-msg");
        var validMsg = $("#valid-msg");
        const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        $(this).on("keyup", function() {
            if( $(this)[0].id === "primary_phone_no" ){
                if( $(this)[0].value === '' ){
                    $("#error-msg").html('');
                } else {
                    if (iti.isValidNumber()) {
                        $("#valid-msg").removeClass("hide");
                        $("#error-msg").addClass("hide");
                    } else {
                        $("#valid-msg").addClass("hide");
                        $("#error-msg").removeClass("hide");
                        $("#error-msg").addClass("error");
                        $("#error-msg").html(errorMap[iti.getValidationError()]);
                    }
                }
            } else if($(this)[0].id === "secondary_phone_no"){
                if( $(this)[0].value === '' ){
                    $("#s-error-msg").html('');
                } else {
                    if (iti.isValidNumber()) {
                        $("#s-valid-msg").removeClass("hide");
                        $("#s-error-msg").addClass("hide");
                    } else {
                        $("#s-valid-msg").addClass("hide");
                        $("#s-error-msg").removeClass("hide");
                        $("#s-error-msg").addClass("error");
                        $("#s-error-msg").html(errorMap[iti.getValidationError()]);
                    }
                }
            }
        });
    });
});

</script>