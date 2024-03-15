<?php

namespace App\Models;

use App\Models\Leaverequest;
use App\Models\Daysallotment;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;
use Illuminate\Notifications\Notifiable;
use App\Http\Traits\HasRolesAndPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_uid',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_no',
        'is_admin',
        'active',
        'row_identifier'
    ];

    protected $primaryKey = 'id';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'user_clients');
    }

    public static function determineDashboardFromRole($slug)
    {
        if( !empty($slug)){
            $dashboard_route = '';

            switch($slug){
                case 'super-admin':
                    $dashboard_route = 'admin/my-dashboard';
                    break;
    
                case 'physician':
                    $dashboard_route = 'physician/my-dashboard';
                        break;

                default:
                    $dashboard_route = '';
                        break;
            }
            return $dashboard_route;
        }
    }

    public static function countUsersByRole($roleId)
    {
        return DB::select('select count(*) total
        from users u
        inner join roles_users ru on ru.user_id = u.id
        where ru.role_id = ?', [$roleId]);
    }

    public static function countUsersByRoleAndGender($roleId, $genderId)
    {
        return DB::select('select count(*) total_users
        from users u
        inner join roles_users ru on ru.user_id = u.id
        inner join personaldetails pd on pd.user_id = u.id
        where ru.role_id = ?
        and pd.gender_id = ?', [$roleId, $genderId]);
    }

    public static function getClientsForUser($id){
        return DB::select("SELECT c._uid id, c.first_name, c.last_name, pt.policy_type, c.phone_no
        FROM clients c
        inner join policytypes pt on pt.id = c.policy_type_id
        WHERE c.id in (select client_id from user_clients where user_id = ?);", [$id]);
    }

    public static function getRoleSlugForUser()
    {
        if( Auth::user() )
        {
            $role = Auth::user()->roles;
            $roleSlug = ($role[0]->slug == 'super-admin') ? 'admin' : $role[0]->slug;

            return $roleSlug;
        }
    }
}