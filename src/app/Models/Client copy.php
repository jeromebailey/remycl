<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        '_uid',
        'first_name',
        'last_name',
        'email_address',
        'phone_no',
        'policy_type_id',
        'policy_no',
        'policy_amount',
        'policy_balance',
        'policy_start_at',
        'policy_expires_at',
        'active'
    ];

    public function routeNotificationForTwilio($notification)
    {
        // Return the phone number field. You can also format the phone number here if needed.
        return $this->phone_no;
    }

    public static function getAllClients()
    {
        return DB::select("select c._uid '_clientID', c.first_name, c.last_name, c.email_address, c.phone_no, pt.policy_type, c.policy_no
        from clients c
        inner join policytypes pt on pt.id = c.policy_type_id");
    }

    public static function getAllClientsByUserId($id)
    {
        return DB::select("select c._uid '_clientID', c.first_name, c.last_name, c.email_address, c.phone_no, pt.policy_type, c.policy_no
        from clients c
        inner join policytypes pt on pt.id = c.policy_type_id
        where c.id in (select client_id from user_clients where user_id = ?)", [$id]);
    }

    public static function getClientsWithPoliciesExpiring($days){
        return DB::select("SELECT c._uid id, c.first_name, c.last_name, pt.policy_type, c.phone_no, c.policy_no, c.policy_expires_at
        FROM clients c
        inner join policytypes pt on pt.id = c.policy_type_id
        WHERE policy_expires_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ? DAY);", [$days]);
    }

    public static function expiredClientPoliciesForUser($slug){
        switch($slug){
            case 'admin':
                return DB::select("SELECT c._uid id, c.first_name, c.last_name, pt.policy_type, c.phone_no, c.policy_expires_at, c.policy_no
                FROM clients c
                inner join policytypes pt on pt.id = c.policy_type_id
                WHERE policy_expires_at < CURDATE();");
                break;

            case 'sales-exec':
                $id = Auth::user()->id;
                return DB::select("SELECT c._uid id, c.first_name, c.last_name, pt.policy_type, c.phone_no, c.policy_expires_at, c.policy_no
                FROM clients c
                inner join policytypes pt on pt.id = c.policy_type_id
                WHERE policy_expires_at < CURDATE()
                and c.id in (select client_id from user_clients where user_id = ?);", [$id]);
                break;
        }
    }

    public static function getClientDetails($id){
        return DB::select("SELECT c._uid id, c.first_name, c.last_name, pt.policy_type, c.phone_no, c.policy_expires_at, c.phone_no, c.email_address, 
        c.policy_start_at, c.policy_no, c.policy_amount
        FROM clients c
        inner join policytypes pt on pt.id = c.policy_type_id
        WHERE c.id = ?;", [$id]);
    }
}
