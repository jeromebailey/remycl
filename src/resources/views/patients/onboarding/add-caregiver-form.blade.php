<div id="add-caregiver" style="display: none;">
        <form method="post" action="{{route($role_slug .'/add-caregiver-for-patient', ['id' => $id])}}">
            @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group required row mt-3">
                    <label for="primary_caregiver" class="col-md-8 col-form-label">Is primary caregiver?</label>
                    <div class="col-md-4 mt-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_primary_caregiver" id="is_primary_caregiver_yes" value="1">
                            <label class="form-check-label" for="is_primary_caregiver_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_primary_caregiver" checked id="is_primary_caregiver_no" value="0">
                            <label class="form-check-label" for="is_primary_caregiver_no">No</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group required row mt-3">
                    <label for="primary_phone_no" class="col-md-8 col-form-label">Is next of kin?</label>
                    <div class="col-md-4 mt-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="is_next_of_kin_yes" value="1" name="is_next_of_kin">
                            <label class="form-check-label" for="is_next_of_kin_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="is_next_of_kin_no" value="0" name="is_next_of_kin" checked>
                            <label class="form-check-label" for="is_next_of_kin_no">No</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row required mt-3">
                        <label for="first_name" class="col-md-3 col-form-label">First Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{old('first_name')}}" autocomplete="off" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group row required mt-3">
                        <label for="last_name" class="col-md-3 col-form-label">Last Name</label>
                        <div class="col-md-9">
                            <input type="text" name="last_name" class="form-control" id="last_name" value="{{old('last_name')}}" autocomplete="off" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row mt-3">
                        <label for="dob" class="col-md-3 col-form-label">Date of birth</label>
                        <div class="col-md-9">
                            <input type="date" class="form-control" id="dob" name="dob" value="{{old('dob')}}" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group row mt-3">
                        <label for="gender" class="col-md-3 col-form-label">Gender</label>
                        <div class="col-md-9">
                            <select id="gender" name="gender" required class="form-control">
                                <option value="{{old('')}}"></option>
                                @foreach ($genders as $item)
                                    <option value="{{$item->_uid}}" {{ old('gender') == $item->_uid ? 'selected' : '' }}>{{$item->gender}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <h5>Contact Information</h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group required row mt-3">
                        <label for="primary_phone_no" class="col-md-4 col-form-label">Primary Phone No.</label>
                        <div class="col-md-8">
                            <input class="form-control phone" id="primary_phone_no" name="primary_phone_no" value="{{old('primary_phone_no')}}" autocomplete="off" type="tel" required />
                            <span id="valid-msg" class="hide">✓ Valid</span>
                            <span id="error-msg" class="hide"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group row mt-3">
                        <label for="secondary_phone_no" class="col-md-4 col-form-label">Secondary Phone No.</label>
                        <div class="col-md-8">
                            <input class="form-control phone" id="secondary_phone_no" name="secondary_phone_no" value="{{old('secondary_phone_no')}}" autocomplete="off" type="tel" />
                            <span id="s-valid-msg" class="hide">✓ Valid</span>
                            <span id="s-error-msg" class="hide"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row mt-3">
                        <label for="email_address" class="col-md-4 col-form-label">Email Address</label>
                        <div class="col-md-8">
                            <input class="form-control" id="email_address" name="email_address" value="{{old('email_address')}}" autocomplete="off" type="email" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>