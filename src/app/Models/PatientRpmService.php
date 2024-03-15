<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientRpmService extends Model
{
    use HasFactory;

    protected $table = 'patient_rpm_services';

    protected $fillable = [
        'patient_id',
        'rpm_service_id',
        'service_duration_id',
    ];
}
