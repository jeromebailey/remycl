<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Physician extends Model
{
    use HasFactory;

    public static function countTotalPhysicianPatientsForRPMServices($id)
    {
        return DB::select("
        select count(*) total_users
        from physicians_patients pp
        where pp.physician_id = ?", [$id]);
    }

    public static function countTotalPhysicianPatientsForRPMServicesByGender($id, $genderId)
    {
        return DB::select("
        select count(*) total_users
        from physicians_patients pp
        inner join personaldetails pd on pd.user_id = pp.patient_id
        where pp.physician_id = ?
        and pd.gender_id = ?", [$id, $genderId]);
    }

    public static function getPhysiciansWithNoOfPatients()
    {
        return DB::select("
        select u._uid '_physicianID', u.first_name, u.last_name,
        (select count(*)  
        from users up
        inner join roles_users ru on ru.user_id = up.id
        inner join physicians_patients pp on pp.patient_id = up.id
        where ru.role_id = 4
        and pp.physician_id = u.id ) patient_count
        from users u
        inner join roles_users ru on ru.user_id = u.id
        where ru.role_id = 2
        order by u.first_name, u.last_name");
    }

    public static function getPhysiciansDDL()
    {
        return DB::select("select u._uid, u.first_name, u.last_name, h.credentials
        from users u
        inner join roles_users ru on ru.`user_id` = u.`id`
        left join healthprofessionaldetails h on h.user_id = u.id
        where ru.role_id = 2
        and u.active = 1
        order by u.last_name");
    }
}
