<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caregiver extends Model
{
    use HasFactory;

    protected $table = 'caregivers';

    protected $fillable = [
        'user_id',
        'is_primary_caregiver',
        'is_next_of_kin'
    ];

    public function caregivers(){
        return $this->belongsTo(User::class, 'id');
    }
}
