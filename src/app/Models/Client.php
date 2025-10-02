<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Services\ExpirationReminderService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        //'_uid',
        'user_id',
        'first_name',
        'last_name',
        'phone_no',
        'policy_type',
        'policy_no',
        'policy_status',
        'policy_expiration_date'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->_uid = Str::uuid();
        });
    }

    public function routeNotificationForTwilio($notification)
    {
        // Return the phone number field. You can also format the phone number here if needed.
        return $this->phone_no;
    }

    public static function getAllClients()
    {
        return DB::select("select c._uid '_clientID', c.first_name, c.last_name, c.phone_no, c.policy_type, c.policy_no, c.policy_status, c.policy_expiration_date
        from clients c");
    }

    public static function getAllClientsByUserId($id)
    {
        return DB::select("select c._uid '_clientID', c.first_name, c.last_name, c.phone_no, c.policy_type, c.policy_no, c.policy_status, c.policy_expiration_date
        from clients c
        where c.id in (select client_id from user_clients where user_id = ?)", [$id]);
    }

    public static function getClientsWithPoliciesExpiring($days){
        return DB::select("SELECT c._uid id, c.first_name, c.last_name, c.policy_type, c.phone_no, c.policy_no, c.policy_status, c.policy_expiration_date
        FROM clients c
        WHERE policy_expires_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ? DAY);", [$days]);
    }

    public static function expiredClientPoliciesForUser($slug){
        switch($slug){
            case 'admin':
                return DB::select("SELECT c._uid id, c.first_name, c.last_name, c.policy_type, c.phone_no, c.policy_no, c.policy_status, c.policy_expiration_date
                FROM clients c");
                break;

            case 'agent':
                $id = Auth::user()->id;
                return DB::select("SELECT c._uid id, c.first_name, c.last_name, c.policy_type, c.phone_no, c.policy_no, c.policy_status, c.policy_expiration_date
                FROM clients c
                where c.id in (select client_id from user_clients where user_id = ?);", [$id]);
                break;
        }
    }

    public static function getClientDetails($id){
        return DB::select("SELECT c._uid id, c.first_name, c.last_name, c.policy_no, c.policy_type, c.phone_no, c.policy_status, c.policy_expiration_date
        FROM clients c
        WHERE c.id = ?;", [$id]);
    }

    protected function getSmsMessage()
    {
        // Format that works with your SMSHelper::sendPolicyExpiringSMS method
        return "Hello {$this->first_name}, your {$this->policy_type} policy (#{$this->policy_no}) is about to expire. Please renew soon.";
    }

        /**
     * Get the client's full name for SMS
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Schedule SMS reminders for this client
     */
    public function scheduleSmsReminders()
    {
        if (!$this->sms_reminders_enabled || !$this->policy_expiration_date || !$this->phone_no) {
            return false;
        }

        // Make sure phone number is in correct format for Twilio
        //$formattedPhone = $this->formatPhoneNumber($this->phone_no);

        ExpirationReminderService::scheduleAllReminders(
            //$formattedPhone,
            $this->phone_no,
            $this->getSmsMessage(),
            $this->policy_expiration_date,
            'client_' . $this->id
        );

        return true;
    }

    /**
     * Format phone number for Twilio (ensure +1 prefix if US number)
     */
    protected function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If it's a 10-digit US number, add +1
        if (strlen($phone) === 10 && !str_starts_with($phone, '1')) {
            return '+1' . $phone;
        }
        
        // If it's 11 digits starting with 1, add +
        if (strlen($phone) === 11 && str_starts_with($phone, '1')) {
            return '+' . $phone;
        }
        
        return $phone;
    }
}
