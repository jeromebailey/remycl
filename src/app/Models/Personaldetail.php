<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personaldetail extends Model
{
    use HasFactory;

    protected $table = 'personaldetails';

    protected $fillable = [
        //'_uid',
        'user_id',
        'dob',
        'gender_id',
    ];
}
