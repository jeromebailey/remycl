<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invalidatebpreasonspecific extends Model
{
    use HasFactory;

    protected $fillable = [
        '_uid',
        'reason_id',
        'reason_details',
    ];

    public static function getSpecificReasonsByReasonId($id)
    {
        return DB::select("select a._uid 'id', a.reason_details
        from invalidatebpreasonspecifics a
        where a.reason_id = ?;", [$id]);
    }
}
