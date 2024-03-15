<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invalidatebpreason extends Model
{
    use HasFactory;

    protected $fillable = [
        '_uid',
        'reason',
    ];
}
