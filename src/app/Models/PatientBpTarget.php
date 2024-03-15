<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientBpTarget extends Model
{
    use HasFactory;

    protected $table = 'patient_bp_targets';

    protected $fillable = [
        'patient_id',
        'systolic_range',
        'diastolic_range',
        'additional_comments',
    ];

    public function patients(){
        return $this->belongsTo(User::class, 'id');
    }
}
