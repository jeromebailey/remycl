<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bpreadingstatus extends Model
{
    use HasFactory;

    protected $table = 'bpreadingstatus';

    protected $fillable = [
        '_uid',
        'status_name',
        'slug',
    ];

    public function patients(){
        return $this->belongsTo(User::class, 'id');
    }

    public function systolicReading(){
        return $this->hasMany(Bpreading::class, 'systolic_status_id');
    }

    public function diastolicReading(){
        return $this->hasMany(Bpreading::class, 'diastolic_status_id');
    }
}
