<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDuration extends Model
{
    use HasFactory;

    protected $table = 'service_durations';

    protected $fillable = [
        '_uid',
        'duration',
    ];
}
