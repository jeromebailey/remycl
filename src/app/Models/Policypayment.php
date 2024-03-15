<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policypayment extends Model
{
    use HasFactory;

    protected $fillable = [
        '_uid',
        'client_id',
        'amount_paid',
        'paid_at',
        'next_payment_date_at'
    ];
}
