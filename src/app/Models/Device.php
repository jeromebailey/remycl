<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;

    public static function getAllDevices()
    {
        return DB::select('select d._uid, dt.device_type_name, dt.model_no, m.`manufacturer_name`
        from devices d
        inner join devicetypes dt on dt.id = d.device_type_id
        inner join `manufacturers` m on m.id = dt.`manufacturer_id`
        order by dt.device_type_name');
    }

    public static function getDeviceByUID($uid)
    {
        return DB::select('select d._uid, d.device_name, d.description, d.model_no, d.cost, m.`manufacturer_name`
        from devices d
        inner join `manufacturers` m on m.id = d.`manufacturer_id`
        where d._uid = ?;', [$uid]);
    }

    public static function getDeviceStockItems()
    {
        return DB::select('select d._uid, dt.device_type_name, dt.model_no, m.`manufacturer_name`, ds.total, dt.cost
        from devices d
        inner join devicetypes dt on dt.id = d.device_type_id
        inner join `manufacturers` m on m.id = dt.`manufacturer_id`
        inner join devicestocks ds on ds.device_type_id = d.id
        order by dt.device_type_name;');
    }

    public static function getRandomUnassignedDevice($device_type_id)
    {
        return DB::select("select d._uid 'uid', d.imei 'imei'
        from devices d
        where device_type_id = ?
        and d.imei not in (select device_unique_id from assigneddevices)
        order by rand()
        limit 1", [$device_type_id]);
    }
}
