<form method="post" action="{{route($role_slug .'/insert-onboarding-checklist-responses-for-patient', ['id' => $id])}}">
    @csrf

    <div class="row">
        <div class="col-md-6">
            <div class="form-group required row mt-3">
                <label for="rpm_programme_explained_yes" class="col-md-8 col-form-label">Were RPM and the programme's purpose explained to Patient?</label>
                <div class="col-md-4 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rpm_programme_explained" id="rpm_programme_explained_yes" value="1" {{ old('rpm_programme_explained') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="rpm_programme_explained_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rpm_programme_explained" id="rpm_programme_explained_no" value="0" {{ old('rpm_programme_explained') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="rpm_programme_explained_no">No</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group required row mt-3">
                <label for="medications_instructions_reviewed_yes" class="col-md-8 col-form-label">Was the Patient's medications, diagnoses and instructions from Physician reviewed?</label>
                <div class="col-md-4 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="medications_instructions_reviewed" id="medications_instructions_reviewed_yes" value="1" {{ old('medications_instructions_reviewed') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="medications_instructions_reviewed_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="medications_instructions_reviewed" id="medications_instructions_reviewed_no" value="0" {{ old('medications_instructions_reviewed') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="medications_instructions_reviewed_no">No</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group required row mt-3">
                <label for="monitoring_hours_informed_yes" class="col-md-8 col-form-label">Was the Patient informed of the monitoring hours? (Mondays-Fridays 9am to 5pm)</label>
                <div class="col-md-4 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="monitoring_hours_informed" id="monitoring_hours_informed_yes" value="1" {{ old('monitoring_hours_informed') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="monitoring_hours_informed_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="monitoring_hours_informed" id="monitoring_hours_informed_no" value="0" {{ old('monitoring_hours_informed') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="monitoring_hours_informed_no">No</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group required row mt-3">
                <label for="action_for_concerns_informed_yes" class="col-md-8 col-form-label">Was the Patient informed of what to do when they experience a reading or symptoms of concern?</label>
                <div class="col-md-4 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="action_for_concerns_informed" id="action_for_concerns_informed_yes" value="1" {{ old('action_for_concerns_informed') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="action_for_concerns_informed_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="action_for_concerns_informed" id="action_for_concerns_informed_no" value="0" {{ old('action_for_concerns_informed') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="action_for_concerns_informed_no">No</label>
                    </div>
                </div>
            </div>
            </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group required row mt-3">
                <label for="follow_up_responsibility_aware_yes" class="col-md-8 col-form-label">Does Patient know that they are responsible to follow up if they have a concern or they are symptomatic? RPM is not a 24/7 service and is not an emergency unit</label>
                <div class="col-md-4 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="follow_up_responsibility_aware" id="follow_up_responsibility_aware_yes" value="1" {{ old('follow_up_responsibility_aware') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="follow_up_responsibility_aware_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="follow_up_responsibility_aware" id="follow_up_responsibility_aware_no" value="0" {{ old('follow_up_responsibility_aware') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="follow_up_responsibility_aware_no">No</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group required row mt-3">
                <label for="correct_device_confirmed_yes" class="col-md-8 col-form-label">Does the Patient have the correct device for their service?</label>
                <div class="col-md-4 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="correct_device_confirmed" id="correct_device_confirmed_yes" value="1" {{ old('correct_device_confirmed') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="correct_device_confirmed_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="correct_device_confirmed" id="correct_device_confirmed_no" value="0" {{ old('correct_device_confirmed') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="correct_device_confirmed_no">No</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group required row mt-3">
                <label for="serial_number_confirmed_yes" class="col-md-8 col-form-label">Was the serial number on the Inventory Form confirmed with that on the back of the device?</label>
                <div class="col-md-4 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="serial_number_confirmed" id="serial_number_confirmed_yes" value="1" {{ old('serial_number_confirmed') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="serial_number_confirmed_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="serial_number_confirmed" id="serial_number_confirmed_no" value="0" {{ old('serial_number_confirmed') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="serial_number_confirmed_no">No</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group required row mt-3">
                <label for="teach_back_method_used_yes" class="col-md-8 col-form-label">Did you utilize the teach back method with demonstrating the use of the device to the Patient?</label>
                <div class="col-md-4 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="teach_back_method_used" id="teach_back_method_used_yes" value="1" {{ old('teach_back_method_used') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="teach_back_method_used_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="teach_back_method_used" id="teach_back_method_used_no" value="0" {{ old('teach_back_method_used') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="teach_back_method_used_no">No</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group required row mt-3">
                <label for="reading_transmission_confirmed_yes" class="col-md-8 col-form-label">Did Patient do a reading with the device? Was the transmission of the reading confirmed in the My-Vitals web application?</label>
                <div class="col-md-4 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="reading_transmission_confirmed" id="reading_transmission_confirmed_yes" value="1" {{ old('reading_transmission_confirmed') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="reading_transmission_confirmed_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="reading_transmission_confirmed" id="reading_transmission_confirmed_no" value="0" {{ old('reading_transmission_confirmed') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="reading_transmission_confirmed_no">No</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group required row mt-3">
                <label for="device_use_barriers_identified_yes" class="col-md-8 col-form-label">Are there any barriers to the Patient being able to use the device?</label>
                <div class="col-md-4 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="device_use_barriers_identified" id="device_use_barriers_identified_yes" value="1" {{ old('device_use_barriers_identified') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="device_use_barriers_identified_yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="device_use_barriers_identified" id="device_use_barriers_identified_no" value="0" {{ old('device_use_barriers_identified') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="device_use_barriers_identified_no">No</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </div>

</form>