<?php

namespace App\Models;

//use DB;
use Exception;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

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

        $phoneNo = '13453249396';

    // $message = $client->messages
    //   ->create("whatsapp:+13453249396", // to
    //     array(
    //       "from" => "CIC",
    //       "body" => "test"
    //     )
    //   );
    
        //foreach ($phone_numbers as $phone_no) {
            try {
                // Send SMS
                // $message = $client->messages->create(
                //     $phoneNo,
                //     [
                //         'from' => 'CIC',
                //         'body' => $body,
                //     ]
                // );

                $smsInfo = [
                    'firstName' => $firstName,
                    'phoneNumber' => $phoneNo,
                    'p0licyType' => $policyType,
                    'policyNumber' => $policyNo,
                    'expirationDate' => $expiryDate
                ];

                Log::info('SMS sent: ' . json_encode($smsInfo) );
                //$this->info('SMS sent: ' . json_encode($smsInfo));
    
                // Add successful response
                //$response[$phoneNo] = 'SMS sent successfully';
                return true;
            } catch (Exception $e) {
                // Add error response
                //$response[$phoneNo] = 'Failed to send SMS';
                Log::info('Failed to send SMS: ' . $e->getMessage() );
                return false;
            }
       //}
    
        // Return response for each number
        //return response()->json($response);
    }

    public static function sendPolicyLapseUsingSMSHelper($firstName, $policyType, $policyNo, $phoneNo, $templateBody)
    {
        try {
            // Twilio credentials from environment variables
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TOKEN');
            $client = new \Twilio\Rest\Client($sid, $token);
            
            // Replace template placeholders with actual client data
            $body = $templateBody;
            $body = str_replace('[first_name]', $firstName, $body);
            $body = str_replace('[policy_type]', $policyType, $body);
            $body = str_replace('[policy_no]', $policyNo, $body);
            $body = str_replace('[expiry_date]', $expiryDate ?? 'N/A', $body);
            
            // Send SMS using Twilio
            $message = $client->messages->create(
                $phoneNo,
                [
                    'from' => 'CIC', // Your Twilio sender ID
                    'body' => $body,
                ]
            );

            return true; // Success

        } catch (\Exception $e) {
            Log::error('SMS Send Error for ' . $phoneNo . ': ' . $e->getMessage());
            return false; // Failed
        }
    }

    public static function logSmsActivity($clientId, $phoneNumber, $templateType, $status, $errorMessage = null, $sentBy = null)
    {
        try {
            DB::table('sms_logs')->insert([
                'client_id' => $clientId,
                'phone_number' => $phoneNumber,
                'template_type' => $templateType,
                'status' => $status,
                'error_message' => $errorMessage,
                'sent_by' => $sentBy ?? auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
        } catch (Exception $e) {
            Log::error('SMS Log Error: ' . $e->getMessage());
        }
    }

    public static function getAllSMSSentByAnAgent($agentId = null, $status = null){
        // $filter = "";
        // if( $status != null ){
        //     $filter .= " and sl.status = '$status'";
        // }
        // if( $agentId != null ){
        //     $filter .= " and u.id = $agentId";
        // }
        
        return DB::select('select sl.id, concat(c.first_name, " ", c.last_name) client_name, concat(u.first_name, " ", u.last_name) agent_name,
            sl.phone_number, sl.status, sl.template_type, sl.created_at sent_at
            from sms_logs sl
            inner join clients c on c.id = sl.client_id
            inner join users u on u.id = sl.sent_by
            where u.id = ?
            and sl.status = ?
            order by sl.created_at desc', [$agentId, $status]);
    }
}
