<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupPatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'date',
            'gender' => 'required|exists:genders,_uid',
            'primary_phone_no' => 'required',
            'secondary_phone_no' => 'nullable',
            'email_address' => 'required|email',
            'rpm_service' => 'required',
            'service_duration' => 'required|exists:service_durations,_uid',
            'systolic_lower' => 'required|integer',
            'systolic_upper' => 'required|integer',
            'diastolic_lower' => 'required|integer',
            'diastolic_upper' => 'required|integer',
            'patient_give_consent' => 'required|boolean',
        ];
    }
}
