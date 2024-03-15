<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicianPatient extends Model
{
    use HasFactory;

    protected $table = 'physicians_patients';
    public $timestamps = false;

    protected $fillable = [
        'physician_id',
        'patient_id',
    ];
}
