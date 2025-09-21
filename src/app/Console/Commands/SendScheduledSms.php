<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\ScheduledSms;
use App\Models\SMSHelper;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class SendScheduledSms extends Command
{
    protected $signature = 'sms:send';
    protected $description = 'Send scheduled SMS messages';

    public function handle()
    {
        $this->info('Checking for scheduled SMS messages...');
        Log::info('SMS scheduler started - checking expiration reminders');

        $messages = ScheduledSms::where('sent', false)
            ->where('scheduled_at', '<=', now())
            ->get();
Log::info('Messages: ' . json_encode($messages));
        if ($messages->isEmpty()) {
            $this->info('No SMS messages to send.');
            Log::info('No SMS messages to send');
            return;
        }

        // Set a system user for cron job logging (if you have a system user ID)
        $systemUserId = 1; // Change this to your system user ID if available

        foreach ($messages as $message) {
            try {
                // Extract client info from reference_id if available
                $client = null;
                $clientId = null;
                
                if (str_starts_with($message->reference_id, 'client_')) {
                    $clientId = str_replace('client_', '', $message->reference_id);
                    $client = Client::find($clientId);
                }

                // Use your existing SMSHelper to send the message
                $success = SMSHelper::sendPolicyExpiringSMS(
                    $client->first_name ?? 'Customer',
                    $this->extractPolicyType($message->message),
                    $this->extractPolicyNo($message->message),
                    $message->expiration_date->format('Y-m-d'),
                    $message->phone_number
                );

                if ($success) {
                    $message->update([
                        'sent' => true,
                        'sent_at' => now()
                    ]);
                    
                    // Log the successful SMS using your existing method
                    $this->logSms(
                        $clientId ?? $message->reference_id,
                        $message->phone_number,
                        'policy-expiring', // matches your template slug
                        'sent',
                        null
                    );
                    
                    $this->info("Sent {$message->reminder_type} reminder to: {$message->phone_number}");
                    Log::info("Sent {$message->reminder_type} reminder to {$message->phone_number}");
                } else {
                    $this->error("Failed to send SMS to {$message->phone_number}");
                    Log::error("SMS sending failed for {$message->phone_number}");
                    
                    // Log the failed SMS
                    $this->logSms(
                        $clientId ?? $message->reference_id,
                        $message->phone_number,
                        'policy-expiring',
                        'failed',
                        'Twilio API error - check credentials'
                    );
                }
                
            } catch (\Exception $e) {
                $this->error("Failed to send {$message->reminder_type} reminder: " . $e->getMessage());
                Log::error("SMS sending failed: " . $e->getMessage());
                
                // Log the error
                $this->logSms(
                    $clientId ?? $message->reference_id ?? 'unknown',
                    $message->phone_number,
                    'policy-expiring',
                    'failed',
                    $e->getMessage(),
                    $systemUserId
                );
            }
        }
    }

    /**
     * Log SMS activity using your existing method
     */
    protected function logSms($clientId, $phoneNumber, $templateType, $status, $errorMessage = null, $sentBy = null)
    {
        try {
            // Use your existing SMSHelper logging method
            SMSHelper::logSmsActivity($clientId, $phoneNumber, $templateType, $status, $errorMessage, $sentBy);
        } catch (\Exception $e) {
            Log::error('Failed to log SMS activity: ' . $e->getMessage());
        }
    }

    /**
     * Extract policy type from message
     */
    protected function extractPolicyType($message)
    {
        if (preg_match('/your (.*?) policy/', $message, $matches)) {
            return $matches[1];
        }
        return 'Insurance Policy';
    }

    /**
     * Extract policy number from message
     */
    protected function extractPolicyNo($message)
    {
        if (preg_match('/#([A-Z0-9]+)/', $message, $matches)) {
            return $matches[1];
        }
        return 'N/A';
    }
}