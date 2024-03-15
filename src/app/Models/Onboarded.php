<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onboarded extends Model
{
    use HasFactory;

    protected $fillable = [
        '_uid',
        'patient_id',
        'onboarded',
        'date_added_to_queue',
        'date_onboarded',
        'onboarded_by_user_id',
    ];
}
