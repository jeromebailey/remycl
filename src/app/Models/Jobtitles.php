<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobtitles extends Model
{
    use HasFactory;

    protected $table = 'jobtitles';

    protected $fillable = [
        '_uid',
        'job_title',
        'description'
    ];
}
