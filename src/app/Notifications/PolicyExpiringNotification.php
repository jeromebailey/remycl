<?php

namespace App\Notifications;

use App\Models\Client;
use App\Models\Smstemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class PolicyExpiringNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $client_first_name, $expiry_date, $agent_name;

    public function __construct($client, $agentName)
    {
        //
        $this->client_first_name = $client->first_name;
        $this->expiry_date = $client->policy_expires_at;
        $this->agent_name = $agentName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [TwilioChannel::class];
    }

    public function toTwilio($notifiable)
    {
        // $twilioSid = config('services.twilio.sid');
        // $twilioToken = config('services.twilio.token');
        // $twilioFrom = config('services.twilio.from');
        //$twilioTo = $notifiable->phone_no; // Ensure your notifiable model has a phone_number attribute or method

       // $twilioClient = new Client($twilioSid, $twilioToken);

        $body = Smstemplate::where('slug', 'policy-expiring')->get()[0]->template_body;
        $body = str_replace('[first_name]', $this->client_first_name, $body);
        //$body = str_replace('[policy_type]', $policyType, $body);
        //$body = str_replace('[policy_no]', $policyNo, $body);
        $body = str_replace('[expiry_date]', $this->expiry_date, $body);
        $body = str_replace('[agent_name]', $this->agent_name, $body);

        try {
            // $message = $twilioClient->messages->create(
            //     $twilioTo, [
            //         "body" => $body,
            //         "from" => 'CIC',
            //     ]
            // );

            //return $message->sid;
            return (new TwilioSmsMessage($body));
        } catch (\Exception $e) {
            Log::error("Failed to send SMS via Twilio: " . $e->getMessage());
        }
    }
}
