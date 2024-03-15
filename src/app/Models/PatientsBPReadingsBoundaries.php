<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientsBPReadingsBoundaries extends Model
{
    use HasFactory;

    protected $table = 'patients_bp_readings_boundaries';

    protected $fillable = [
        'patient_id',
        'systolic_low_critical',
        'systolic_low',
        'systolic_high',
        'systolic_high_critical',
        'diastolic_low_critical',
        'diastolic_low',
        'diastolic_high',
        'diastolic_high_critical',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class);
    }
}
