<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientBgTarget extends Model
{
    use HasFactory;

    protected $table = 'patient_bg_targets';

    protected $fillable = [
        'patient_id',
        'before_meals_range',
        '2_hrs_after_meals_<',
        'additional_comments',
    ];
}
