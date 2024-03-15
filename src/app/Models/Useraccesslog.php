<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Useraccesslog extends Model
{
    use HasFactory;

    protected $fillable = [
        '_uid',
        'user_id',
        'useraccesstype_id',
        'description',
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function useraccesstype(){
        return $this->belongsTo(Useraccesstype::class);
    }

    public static function logUserAction($user_id, $access_slug, $description=null){
        DB::beginTransaction();
        $access_type_id = 0;

        try{
            $access_type_id = Useraccesstype::where('slug', $access_slug)->get()[0]->id;

            try{
                Useraccesslog::create([
                    '_uid' => Str::uuid()->toString(),
                    'user_id' => $user_id,
                    'useraccesstype_id' => $access_type_id,
                    'description' => $description,
                ]);
                DB::commit();
            } catch(QueryException $e){
                DB::rollBack();
                //AppException::logException( Useraccesslog::class, __METHOD__, $e);
                $data = [
                    'controller' => __CLASS__,
                    'function' => __FUNCTION__,
                    'message' => "Error adding access log:" . $e->getMessage(),
                    'stack_trace' => $e,
                ];
                ErrorLog::logError($data);
            }
        } catch(QueryException $e){
            DB::rollBack();
            //AppException::logException( Useraccesslog::class, __METHOD__, $e);
            $data = [
                'controller' => __CLASS__,
                'function' => __FUNCTION__,
                'message' => "Error getting access type id:" . $e->getMessage(),
                'stack_trace' => $e,
            ];
            ErrorLog::logError($data);
        }
    }
}
