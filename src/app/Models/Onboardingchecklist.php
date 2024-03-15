<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onboardingchecklist extends Model
{
    use HasFactory;

    protected $table = 'onboardingchecklists';

    protected $fillable = [
        'patient_id',
        'patient_contacted',
        'service_explained_to_patient',
        'device_assigned_to_patient',
        'patient_have_device',
        'device_usage_explained_to_patient',
    ];
}
