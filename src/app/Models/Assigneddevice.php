<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assigneddevice extends Model
{
    use HasFactory;

    protected $table = 'assigneddevices';

    protected $fillable = [
        '_uid',
        'device_unique_id',
        'patient_user_id',
        'assigned_by_user_id',
    ];
}
