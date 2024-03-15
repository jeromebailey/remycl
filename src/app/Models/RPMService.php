<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RPMService extends Model
{
    use HasFactory;

    protected $table = 'rpm_services';

    protected $fillable = [
        '_uid',
        'rpm_service',
        'slug',
    ];

    public static function getPatientRPMServiceCount($rpmServiceId)
    {
        return DB::select("select rs.rpm_service, count(*) as amount
        from patient_rpm_services prs
        left join rpm_services rs on rs.id = prs.rpm_service_id
        left join physicians_patients pp on pp.patient_id = prs.patient_id
        where rs.id = ?", [$rpmServiceId]);
    }

    public static function getPatientRPMServiceCountForPhysician($physicianId, $rpmServiceId)
    {
        return DB::select("select rs.rpm_service, count(*) as amount
        from patient_rpm_services prs
        left join rpm_services rs on rs.id = prs.rpm_service_id
        left join physicians_patients pp on pp.patient_id = prs.patient_id
        where pp.physician_id = ?
        and rs.id = ?", [$physicianId, $rpmServiceId]);
    }
}
