<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Twilio\Exceptions\TwilioException;

class VoiceController extends Controller
{
    //
    public function __construct() {
        // Twilio credentials
        $this->account_sid = env('TWILIO_SID');
        $this->auth_token = env('TWILIO_TOKEN');
    
        //The twilio number you purchased
        $this->from = env('TWILIO_FROM');
    
        // Initialize the Programmable Voice API
        $this->client = new Client($this->account_sid, $this->auth_token);
      }

      public function initiateCall(Request $request) {
        try{
        //Lookup phone number to make sure it is valid before initiating call
        $phone_number = $this->client->lookups->v1->phoneNumbers($request->phone_number)->fetch();
    
        // If phone number is valid and exists
        if($phone_number) {
          // Initiate call and record call
          $call = $this->client->account->calls->create(
                  $request->phone_number, // Destination phone number
                  $this->from, // Valid Twilio phone number
                  array(
                    "record" => True,
                    "url" => "https://my-vitals.com/admin/twiml-response"
                  ));
                    //"url" => "http://demo.twilio.com/docs/voice.xml"));
    
          if($call) {
            echo 'Call initiated successfully';
          } else {
            echo 'Call failed!';
          }
        }
      } catch (TwilioException $e) {
        // Handle Twilio-related exceptions
        echo 'Error: ' . $e->getMessage();
    } catch (\Exception $e) {
        // Handle all other exceptions
        echo 'An error occurred: ' . $e->getMessage();
    }
      }

      public function generateTwiml()
      {
        $response = new \Twilio\TwiML\VoiceResponse();
        $response->say("Hello, this is a test call from my-vitals.");

        return response($response)
                ->header('Content-Type', 'text/xml');
      }

      public function errorOccurred()
      {
        $response = new \Twilio\TwiML\VoiceResponse();
        $response->say("Error occurred");

        return response($response)
                ->header('Content-Type', 'text/xml');
      }
}
