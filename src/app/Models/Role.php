<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, HasRolesAndPermissions;

    protected $fillable = [
        'role_name',
        'slug'
    ];

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'permissions_roles');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'roles_users');
    }
}
