<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OnboardingChecklistRequest extends FormRequest
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
            'rpm_programme_explained' => 'required|in:0,1',
            'medications_instructions_reviewed' => 'required|in:0,1',
            'monitoring_hours_informed' => 'required|in:0,1',
            'action_for_concerns_informed' => 'required|in:0,1',
            'follow_up_responsibility_aware' => 'required|in:0,1',
            'correct_device_confirmed' => 'required|in:0,1',
            'serial_number_confirmed' => 'required|in:0,1',
            'teach_back_method_used' => 'required|in:0,1',
            'reading_transmission_confirmed' => 'required|in:0,1',
            'device_use_barriers_identified' => 'required|in:0,1',
        ];
    }
}
