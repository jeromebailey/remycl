<?php

namespace App\Models;

use Exception;
use Twilio\Rest\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SMSHelper extends Model
{
    use HasFactory;

    public static function sendRecoverCodeSMS($phone_no, $code){
        //return response()->json(['result' => $code]);
        $sid    = env( 'TWILIO_SID' );
        $token  = env( 'TWILIO_TOKEN' );
        $client = new Client( $sid, $token );
        
        try{
            //$sms = Sms::where('slug', 'recovery-code')->get();
            //$body = $sms[0]->body;
            
            $body = '';
            //$body = str_replace('[recovery_code]', $code, $body);

            try{
                $client->messages->create(
                    //'1'.$phone_no,
                    $phone_no,
                    [
                        'from' => 'CIC',
                        'body' => $body,
                    ]
                );
            } catch(Exception $b){
                //dd('didnt send sms');
                return response()->json(['result' => 'didnt send sms']);
            }
            
        } catch(QueryException $q){
            return response()->json(['result' => 'didnt get sms body']);
            //dd('didnt get sms body');
        }
    }

    public static function sendSMS($phone_numbers, $code){
        // Twilio credentials from environment variables
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_TOKEN');
        $client = new Client($sid, $token);
    
        // SMS body - could be modified to include dynamic data like $code
        $body = 'Test SMS';
        //$body = str_replace('[recovery_code]', $code, $body);
    
        // Response array
        $response = [];
    
        foreach ($phone_numbers as $phone_no) {
            try {
                // Send SMS
                $message = $client->messages->create(
                    $phone_no,
                    [
                        'from' => 'CIC',
                        'body' => $body,
                    ]
                );
    
                // Add successful response
                $response[$phone_no] = 'SMS sent successfully';
    
            } catch (Exception $e) {
                // Add error response
                $response[$phone_no] = 'Failed to send SMS';
            }
        }
    
        // Return response for each number
        return response()->json($response);
    }

    public static function sendPolicyExpiringSMS($firstName, $policyType, $policyNo, $expiryDate, $phoneNo){
        // Twilio credentials from environment variables
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_TOKEN');
        $client = new Client($sid, $token);
        
        $body = Smstemplate::where('slug', 'policy-expiring')->get()[0]->template_body;
        $body = str_replace('[first_name]', $firstName, $body);
        $body = str_replace('[policy_type]', $policyType, $body);
        $body = str_replace('[policy_no]', $policyNo, $body);
        $body = str_replace('[expiry_date]', $expiryDate, $body);
        
        // Response array
        $response = [];

        $phoneNo = '13453222145';
    
        //foreach ($phone_numbers as $phone_no) {
            try {
                // Send SMS
                $message = $client->messages->create(
                    $phoneNo,
                    [
                        'from' => 'CIC',
                        'body' => $body,
                    ]
                );
    
                // Add successful response
                //$response[$phoneNo] = 'SMS sent successfully';
    return true;
            } catch (Exception $e) {
                // Add error response
                //$response[$phoneNo] = 'Failed to send SMS';
                return false;
            }
       //}
    
        // Return response for each number
        //return response()->json($response);
    }
    
}
