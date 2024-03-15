<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientContactInformation extends Model
{
    use HasFactory;

    protected $table = 'patientContactInformation';

    protected $fillable = [
        'patient_id',
        'primary_phone_no',
        'secondary_phone_no',
        //'email_address',
    ];
}
