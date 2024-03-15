<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smstemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        '_uid',
        'template_title',
        'slug',
        'template_body',
    ];

    
}
