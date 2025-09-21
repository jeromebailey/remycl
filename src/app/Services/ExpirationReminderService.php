<?php

namespace App\Services;

use App\Models\ScheduledSms;
use Carbon\Carbon;

class ExpirationReminderService
{
    public static function scheduleAllReminders($phoneNumber, $message, $expirationDate, $referenceId = null)
    {
        $reminders = [
            '1_month' => $expirationDate->copy()->subMonth()->setTime(16, 4, 0),
            '15_days' => $expirationDate->copy()->subDays(15)->setTime(16, 0, 0),
            '3_days' => $expirationDate->copy()->subDays(3)->setTime(16, 0, 0),
        ];

        foreach ($reminders as $type => $sendDate) {
            self::scheduleSingleReminder($phoneNumber, $message, $sendDate, $expirationDate, $type, $referenceId);
        }
    }

    public static function scheduleSingleReminder($phoneNumber, $message, $sendDate, $expirationDate, $reminderType, $referenceId = null)
    {
        // Only schedule if the send date is in the future
        if ($sendDate->isFuture()) {
            return ScheduledSms::create([
                'phone_number' => $phoneNumber,
                'message' => self::formatMessage($message, $expirationDate, $reminderType),
                'scheduled_at' => $sendDate,
                'expiration_date' => $expirationDate,
                'reminder_type' => $reminderType,
                'reference_id' => $referenceId
            ]);
        }

        return null;
    }

    protected static function formatMessage($baseMessage, $expirationDate, $reminderType)
    {
        $daysLeft = now()->diffInDays($expirationDate);
        
        $reminderTexts = [
            '1_month' => "1 month reminder",
            '15_days' => "15 days reminder", 
            '3_days' => "3 days reminder"
        ];

        $reminderText = $reminderTexts[$reminderType] ?? "Reminder";

        // Format that works with your SMSHelper expectations
        return "{$baseMessage} Your policy expires on {$expirationDate->format('F j, Y')}. {$reminderText} - {$daysLeft} days remaining.";
    }

    public static function rescheduleReminders($referenceId, $newExpirationDate)
    {
        // Delete existing reminders
        ScheduledSms::where('reference_id', $referenceId)
            ->where('sent', false)
            ->delete();

        // Get the original message from one of the deleted reminders
        $original = ScheduledSms::where('reference_id', $referenceId)
            ->where('sent', true)
            ->first();

        if ($original) {
            // Reschedule with new expiration date
            self::scheduleAllReminders(
                $original->phone_number,
                self::extractBaseMessage($original->message),
                $newExpirationDate,
                $referenceId
            );
        }
    }

    protected static function extractBaseMessage($formattedMessage)
    {
        // Remove the reminder prefix and expiration info
        return preg_replace('/\[.*?\]\s*(.*?)\. Expires on:.*/', '$1', $formattedMessage);
    }
}