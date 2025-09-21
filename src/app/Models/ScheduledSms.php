<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledSms extends Model
{
    use HasFactory;

    protected $table = 'scheduled_sms';
    
    protected $fillable = [
        'phone_number',
        'message',
        'scheduled_at',
        'expiration_date',
        'reminder_type',
        'reference_id',
        'sent',
        'sent_at'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'expiration_date' => 'datetime',
        'sent_at' => 'datetime',
        'sent' => 'boolean'
    ];
}
