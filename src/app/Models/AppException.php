<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppException extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_name',
        'function_name',
        'exception'
    ];

    public static function logException($className, $functionName, $exception){
        AppException::create([
            'class_name' => $className,
            'function_name' => $functionName,
            'exception' => $exception
        ]);
    }
}
