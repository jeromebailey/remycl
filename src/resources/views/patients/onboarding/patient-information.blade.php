<form method="post">
    @csrf
    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="first_name" class="col-md-3 col-form-label">First Name:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control-plaintext" id="first_name" name="first_name" value="{{$patient_info->first_name ?? ''}}" autocomplete="off" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="last_name" class="col-md-3 col-form-label">Last Name:</label>
                                <div class="col-md-9">
                                    <input type="text" name="last_name" class="form-control-plaintext" id="last_name" value="{{$patient_info->last_name ?? ''}}" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="dob" class="col-md-3 col-form-label">Date of birth:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control-plaintext" id="dob" name="dob" value="{{date('F d, Y', strtotime($patient_info->dob ?? ''))}}" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="gender" class="col-md-3 col-form-label">Gender:</label>
                                <div class="col-md-9">
                                <input type="text" class="form-control-plaintext" id="dob" name="dob" value="{{$patient_info->gender ?? ''}}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row mt-3">
                                <label for="dob" class="col-md-3 col-form-label">RPM Service:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control-plaintext" id="dob" name="dob" value="{{$patient_info->rpm_service ?? ''}}" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        
                    </div>
</form>


