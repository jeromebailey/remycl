<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ErrorLog extends Model
{
    use HasFactory;

    protected $table = 'error_logs';

    protected $fillable = [
        'controller',
        'function',
        'message',
        'stack_trace',
    ];

    public static function logError($data)
    //public static function logError($controller, $function, $message, $stack)
    {
        try{
            DB::table('error_logs')->insert([
                'controller' => $data['controller'],
                'function' => $data['function'],
                'message' => $data['message'],
                'stack_trace' => $data['stack_trace'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } catch(Exception $e)
        {
            Log::error('Error inserting into error_logs table: ' . $e->getMessage());
        }
        
    }
}
