<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bgreading extends Model
{
    use HasFactory;

    protected $table = 'bgreadings';

    protected $fillable = [
        '_uid',
        'patient_id',
        'device_id',
        'glucose',
        'readingPeriod',
    ];

    public static function countBGReadingsPerMonthByYear($year)
    {
        return DB::select("select month(bp.time) month_no, count(*) month_total
        from bgreadings bp
        where year(bp.time) = ?
        group by month(bp.time)
        order by month(bp.time);", [$year]);
    }

    public static function countBGReadingsPerMonthByYearForPhysician($id, $year)
    {
        return DB::select("select month(bp.time) month_no, count(*) month_total
        from bgreadings bp
        inner join users u on u.id = bp.patient_id
        inner join physicians_patients pp on pp.patient_id = u.id
        where pp.physician_id = ?
        and year(bp.time) = ?
        group by month(bp.time)
        order by month(bp.time);", [$id, $year]);
    }
}
