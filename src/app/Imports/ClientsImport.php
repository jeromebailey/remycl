<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\ScheduledSms;
use App\Models\SMSHelper;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $client = new Client([
            'user_id' => auth()->user()->id,
            'first_name' => $row['first_name'] ?? null,
            'last_name' => $row['last_name'] ?? null,
            'phone_no' => $row['phone_no'] ?? null,
            'policy_type' => $row['policy_type'] ?? null,
            'policy_no' => $row['policy_no'] ?? null,
            'policy_status' => $row['policy_status'] ?? null,
            'policy_expiration_date' => $this->parseExcelDate($row['policy_expiration_date'] ?? null),
        ]);

        // Save client so we get ID
        $client->save();
        Log::info('Imported client: ' . json_encode($client));
        
        // Create SMS schedules if expiration exists
        if ($client->policy_expiration_date) {
            $this->handleSmsScheduling($client);
        }

        return $client;
    }

    private function parseExcelDate($value)
    {
        try {
            // If it's a number, treat as Excel serial date
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }

            // Else try string format (e.g., "19/10/2025")
            return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null; // Or handle logging
        }
    }

    private function handleSmsScheduling(Client $client)
    {
        $expiration = Carbon::parse($client->policy_expiration_date);
        $now = Carbon::now();
        $daysUntilExpiration = $now->diffInDays($expiration, false); // false = can be negative

        Log::info("Client {$client->first_name} expires in {$daysUntilExpiration} days");

        // If already expired, don't send anything
        if ($daysUntilExpiration < 0) {
            Log::info("Policy already expired for {$client->first_name}, skipping SMS");
            return;
        }

        // Define all possible reminders
        $allReminders = [
            [
                'label' => '1_month',
                'days_before' => 30,
                'template' => "[1 month reminder] Hello :name, your :policy_type policy (#:policy_no) is about to expire. Expires on: :expiry (:days days left)",
            ],
            [
                'label' => '15_days',
                'days_before' => 15,
                'template' => "[15 days reminder] Hello :name, your :policy_type policy (#:policy_no) is about to expire. Expires on: :expiry (:days days left)",
            ],
            [
                'label' => '3_days',
                'days_before' => 3,
                'template' => "[3 days reminder] Hello :name, your :policy_type policy (#:policy_no) is about to expire. Expires on: :expiry (:days days left)",
            ],
        ];

        // Determine which reminders to send based on days until expiration
        if ($daysUntilExpiration <= 3) {
            // 3 days or less - send 3 day reminder immediately
            $this->sendImmediateSms($client, $allReminders[2], $daysUntilExpiration);
            Log::info("Sent immediate 3-day reminder for {$client->first_name}");
            
        } elseif ($daysUntilExpiration <= 15) {
            // 15 days or less - send 15 day reminder immediately and schedule 3 day
            $this->sendImmediateSms($client, $allReminders[1], $daysUntilExpiration);
            $this->scheduleReminder($client, $allReminders[2], $expiration);
            Log::info("Sent immediate 15-day reminder and scheduled 3-day for {$client->first_name}");
            
        } elseif ($daysUntilExpiration <= 30) {
            // 30 days or less - send 1 month reminder immediately and schedule others
            $this->sendImmediateSms($client, $allReminders[0], $daysUntilExpiration);
            $this->scheduleReminder($client, $allReminders[1], $expiration);
            $this->scheduleReminder($client, $allReminders[2], $expiration);
            Log::info("Sent immediate 1-month reminder and scheduled others for {$client->first_name}");
            
        } else {
            // More than 30 days - schedule all reminders normally
            foreach ($allReminders as $reminder) {
                $this->scheduleReminder($client, $reminder, $expiration);
            }
            Log::info("Scheduled all future reminders for {$client->first_name}");
        }
    }

    private function sendImmediateSms(Client $client, array $reminder, int $actualDaysLeft)
    {
        try {
            // Send SMS immediately using your existing SMSHelper
            $success = SMSHelper::sendPolicyExpiringSMS(
                $client->first_name,
                $client->policy_type,
                $client->policy_no,
                $client->policy_expiration_date,
                $client->phone_no
            );

            // Create a scheduled SMS record marked as sent
            $message = str_replace(
                [':name', ':policy_type', ':policy_no', ':expiry', ':days'],
                [
                    $client->first_name, 
                    $client->policy_type, 
                    $client->policy_no, 
                    Carbon::parse($client->policy_expiration_date)->format('M d, Y'), 
                    $actualDaysLeft
                ],
                $reminder['template']
            );

            ScheduledSms::create([
                'phone_number' => $client->phone_no,
                'message' => $message,
                'scheduled_at' => now(),
                'expiration_date' => Carbon::parse($client->policy_expiration_date)->endOfDay(),
                'reminder_type' => $reminder['label'],
                'reference_id' => 'client_' . $client->id,
                'sent' => true,
                'sent_at' => now(),
            ]);

            // Log the SMS activity
            SMSHelper::logSmsActivity(
                $client->id,
                $client->phone_no,
                'policy-expiring',
                $success ? 'sent' : 'failed',
                $success ? null : 'SMS sending failed',
                auth()->id()
            );

            Log::info("Immediate SMS sent for {$client->first_name}: {$reminder['label']}");

        } catch (\Exception $e) {
            Log::error("Failed to send immediate SMS for {$client->first_name}: " . $e->getMessage());
            
            // Log the failed attempt
            SMSHelper::logSmsActivity(
                $client->id,
                $client->phone_no,
                'policy-expiring',
                'failed',
                $e->getMessage(),
                auth()->id()
            );
        }
    }

    private function scheduleReminder(Client $client, array $reminder, Carbon $expiration)
    {
        $sendDate = $expiration->copy()->subDays($reminder['days_before'])->setTime(12, 14, 0);
        
        // Only schedule if the send date is in the future
        if ($sendDate->isFuture()) {
            ScheduledSms::create([
                'phone_number' => $client->phone_no,
                'message' => str_replace(
                    [':name', ':policy_type', ':policy_no', ':expiry', ':days'],
                    [
                        $client->first_name, 
                        $client->policy_type, 
                        $client->policy_no, 
                        $expiration->format('M d, Y'), 
                        $reminder['days_before']
                    ],
                    $reminder['template']
                ),
                'scheduled_at' => $sendDate,
                'expiration_date' => $expiration->copy()->endOfDay(),
                'reminder_type' => $reminder['label'],
                'reference_id' => 'client_' . $client->id,
                'sent' => false,
            ]);

            Log::info("Scheduled {$reminder['label']} for {$client->first_name} on {$sendDate->format('Y-m-d H:i')}");
        } else {
            Log::info("Skipped scheduling {$reminder['label']} for {$client->first_name} - send date is in the past");
        }
    }
}