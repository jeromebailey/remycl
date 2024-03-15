<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeStatuses extends Model
{
    use HasFactory;

    protected $table = 'employeestatuses';

    protected $fillable = [
        '_uid',
        'employee_status'
    ];
}
