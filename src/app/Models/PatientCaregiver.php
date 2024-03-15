<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCaregiver extends Model
{
    use HasFactory;

    protected $table = 'patient_caregivers';

    protected $fillable = [
        'patient_id',
        'caregiver_id',
    ];
}
