<?php

namespace App\Models;

use App\Mail\VitalSyncMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppMailer extends Model
{
    use HasFactory;

    public static function sendCriticalBPReadingEmail($emailAddresses, $patient_name, $reading){
        $body = array(
            'patient_name' => $patient_name,
            'reading' => $reading
        );
//dd($body);
        $subject = 'Critical Blood Pressure Reading';
        $view = 'mail.critical-reading';

        foreach( $emailAddresses as $email ){
            Mail::to($email)->send(new VitalSyncMail($subject, $body, $view));
        }

        if( count( Mail::failures() ) > 0 )
                return false;
            return true;
    }
}
