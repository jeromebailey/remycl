<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bpreading extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bpreadings';

    protected $fillable = [
        '_uid',
        'patient_id',
        'device_id',
        'time',
        'systolic',
        'diastolic',
        'pulse',
        'arrhythmia',
        'systolic_status_id',
        'diastolic_status_id',
        'invalidated'
    ];

    protected $dates = ['deleted_at'];

    public function patients(){
        return $this->belongsTo(User::class, 'id');
    }

    public function systolicStatus(){
        return $this->belongsTo(Bpreadingstatus::class, 'systolic_status_id');
    }

    public function diastolicStatus(){
        return $this->belongsTo(Bpreadingstatus::class, 'diastolic_status_id');
    }

    public static function getBPReadingsForPatient($patientId, $statusId=null)
    {
        $queryParams = [$patientId];

        $statusIdString = "";
        if ($statusId !== null) {
            $statusIdString = " and (b.systolic_status_id = ? OR b.diastolic_status_id = ?)";
            array_push($queryParams, $statusId, $statusId);
        }

        return DB::select('select b._uid, b.systolic, b.diastolic, b.pulse, b.arrhythmia, b.time, 
        b.systolic_status_id, b.diastolic_status_id, systolic_status.status_name AS systolic_status, 
        diastolic_status.status_name AS diastolic_status
        from bpreadings b
        inner join users u on u.id = b.patient_id
        INNER JOIN bpreadingstatus systolic_status ON systolic_status.id = b.systolic_status_id
        INNER JOIN bpreadingstatus diastolic_status ON diastolic_status.id = b.diastolic_status_id
        where b.patient_id = ?
        '. $statusIdString . '
        and b.invalidated = 0
        and b.deleted_at is NULL
        order by b.systolic_status_id desc, b.diastolic_status_id desc;', $queryParams);
    }

    public static function getBPReadingsForPhysiciansPatients($physicianId)
    {
        return DB::select("select u._uid '_patientID', u.first_name, u.last_name, b._uid '_readingID', b.systolic, b.diastolic, b.pulse, b.arrhythmia, b.time, b.created_at
        from bpreadings b
        inner join users u on u.id = b.patient_id
        inner join physicians_patients pp on pp.patient_id = u.id
        where pp.physician_id = ?
        and b.invalidated = 0
        and b.deleted_at is NULL", [$physicianId]);
    }

    public static function getBPReadingsForAllPatients()
    {
        return DB::select('select u.first_name, u.last_name, b._uid, b.systolic, b.diastolic, b.pulse, b.arrhythmia, b.time, b.created_at
        from bpreadings b
        inner join users u on u.id = b.patient_id
        and b.invalidated = 0
        and b.deleted_at is NULL');
    }

    public static function countBPReadingsPerMonthByYear($year)
    {
        return DB::select("select month(b.time) month_no, count(*) month_total
        from bpreadings b
        where year(b.time) = ?
        and b.invalidated = 0
        and b.deleted_at is NULL
        group by month(b.time)
        order by month(b.time);", [$year]);
    }

    public static function countBPReadingsPerMonthByYearForPhysician($id, $year)
    {
        return DB::select("select month(bp.time) month_no, count(*) month_total
        from bpreadings bp
        inner join users u on u.id = bp.patient_id
        inner join physicians_patients pp on pp.patient_id = u.id
        where pp.physician_id = ?
        and year(bp.time) = ?
        and bp.invalidated = 0
        and bp.deleted_at is NULL
        group by month(bp.time)
        order by month(bp.time);", [$id, $year]);
    }

    public static function getPatientsWithHighBPReadingsByStatusId( $statusId, $limit=null)
    {
        $limitStr = ($limit !== null) ? " limit $limit" : "";

        return DB::select("select u.first_name, u.last_name, concat(b.systolic, '/', b.diastolic) reading, b.pulse, b.time 'taken_on'
        from bpreadings b
        inner join users u on u.id = b.patient_id
        where b.systolic_status_id = ?
        and b.invalidated = 0
        and b.deleted_at is NULL
        order by systolic desc, diastolic desc, b.time desc
        $limitStr", [$statusId]);
    }

    // public static function getPatientsWithBPReadingsByStatusId( $statusId, $limit=null)
    // {
    //     $limitStr = ($limit !== null) ? " limit $limit" : "";

    //     return DB::select("select u.first_name, u.last_name, concat(b.systolic, '/', b.diastolic) reading, b.pulse, b.time 'taken_on'
    //     from bpreadings b
    //     inner join users u on u.id = b.patient_id
    //     where b.systolic_status_id = ?
    //     or b.diastolic_status_id = ?
    //     order by systolic desc, diastolic desc
    //     $limitStr", [$statusId, $statusId]);
    // }

    public static function countHighBPReadingsByStatusId($statusId)
    {
        return DB::select("select count(*) amount
        from bpreadings b
        where b.systolic_status_id = ?
        or b.diastolic_status_id = ?
        and b.invalidated = 0
        and b.deleted_at is NULL", [$statusId, $statusId]);
    }

    // public static function countBPReadingsByStatusId($statusId)
    // {
    //     return DB::select("select count(*) amount
    //     from bpreadings b
    //     where b.systolic_status_id = ?
    //     or b.diastolic_status_id = ?", [$statusId, $statusId]);
    // }

    public static function getAverageBPReadingForPatientByYear($patientId, $year)
    {
        return DB::select("SELECT YEAR(time) AS year, MONTH(time) AS month, AVG(systolic) AS average_systolic, AVG(diastolic) AS average_diastolic
        FROM bpreadings
        WHERE YEAR(time) = ?
        and patient_id = ?
        GROUP BY YEAR(time), MONTH(time);", [$year, $patientId]);
    }

    public static function getBpReadingsForPatientByDateRange($patientId, $startDate, $endDate)
    {

        return DB::select("select u._uid '_patientID', b._uid '_readingID', b.systolic, b.diastolic, b.pulse, b.arrhythmia, b.time, 
        b.systolic_status_id, b.diastolic_status_id, systolic_status.status_name AS systolic_status, 
        diastolic_status.status_name AS diastolic_status, MONTH(b.time) AS month
        from bpreadings b
        inner join users u on u.id = b.patient_id
        INNER JOIN bpreadingstatus systolic_status ON systolic_status.id = b.systolic_status_id
        INNER JOIN bpreadingstatus diastolic_status ON diastolic_status.id = b.diastolic_status_id
        where b.patient_id = ?
        and DATE_FORMAT(b.time, '%Y-%m-%d') between ? and ?
        and b.invalidated = 0
        and b.deleted_at is NULL
        order by b.time asc;", [$patientId, $startDate, $endDate]);
    }

    public static function getAverageBPReadingForAPatientByDateRange($patientId, $startDate, $endDate)
    {
        return DB::select("select avg(b.systolic) average_systolic, avg(b.diastolic) average_diastolic
        from bpreadings b
        where b.patient_id = ?
        and DATE_FORMAT(b.time, '%Y-%m-%d') between ? and ?
        and b.invalidated = 0
        and b.deleted_at is NULL", [$patientId, $startDate, $endDate]);
    }

    public static function getSpecificReadingForAPatient($patientId, $readingUId)
    {
        return DB::select("  select b._uid, b.systolic, b.diastolic, b.pulse, b.arrhythmia, b.time, 
        b.systolic_status_id, b.diastolic_status_id, systolic_status.status_name AS systolic_status, 
        diastolic_status.status_name AS diastolic_status
        from bpreadings b
        inner join users u on u.id = b.patient_id
        INNER JOIN bpreadingstatus systolic_status ON systolic_status.id = b.systolic_status_id
        INNER JOIN bpreadingstatus diastolic_status ON diastolic_status.id = b.diastolic_status_id
        where b.patient_id = ?
        and b._uid = ?
        and b.invalidated = 0
        and b.deleted_at is NULL", [$patientId, $readingUId]);
    }

    public static function getFirstBPReadingForAPatient($patientId)
    {
        return DB::select("select b.time 'first_reading_date'
        from bpreadings b
        where patient_id = ?
        and b.invalidated = 0
        and b.deleted_at is NULL
        order by b.time asc
        limit 0, 1;", [$patientId]);
    }

    public static function getNoOfBPReadingsByStatusIdForAPatient($patientId, $statusId, $startDate, $endDate)
    {
        return DB::select("select count(*) readings_within_range
        from bpreadings b
        where b.patient_id = ?
        and b.systolic_status_id =?
        and b.diastolic_status_id = ?
        and DATE_FORMAT(b.time, '%Y-%m-%d') between ? and ?
        and b.invalidated = 0", [$patientId, $statusId, $statusId, $startDate, $endDate]);
    }

    public static function getTotalNoOfBPReadingsForAPatient($patientId, $startDate, $endDate)
    {
        return DB::select("select count(*) total_readings
        from bpreadings b
        where b.patient_id = ?
        and DATE_FORMAT(b.time, '%Y-%m-%d') between ? and ?
        and b.invalidated = 0", [$patientId, $startDate, $endDate]);
    }

    public static function getAverageMonthlyBPReadingByYearForAPatient($patientId, $year)
    {
        return DB::select("WITH RECURSIVE Months(month_no) AS (
            SELECT 1
            UNION ALL
            SELECT month_no + 1 FROM Months WHERE month_no < 12
          )
          SELECT 
            m.month_no, 
            COALESCE(AVG(b.systolic), 0) AS average_systolic, 
            COALESCE(AVG(b.diastolic), 0) AS average_diastolic
          FROM 
            Months m
          LEFT JOIN bpreadings b ON m.month_no = MONTH(b.time)
            AND b.patient_id = ?
            AND YEAR(b.time) = ?
            AND b.invalidated = 0
            AND b.deleted_at IS NULL
          GROUP BY 
            m.month_no
          ORDER BY 
            m.month_no;", [$patientId, $year]);
    }

    public static function getNoOfDaysDataWasTransmittedForAPatientByDateRange($patientId, $startDate, $endDate)
    {
        return DB::select("select count(distinct(day(b.time))) no_of_days
        from bpreadings b
        where b.patient_id = ?
        and DATE_FORMAT(b.time, '%Y-%m-%d') between ? and ?
        and b.invalidated = 0
        and b.deleted_at is NULL;", [$patientId, $startDate, $endDate]);
    }
}
