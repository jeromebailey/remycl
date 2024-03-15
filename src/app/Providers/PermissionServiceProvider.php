<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->defineGates();
    }

    private function defineGates()
    {
        foreach (Permission::all() as $permission) {
            Gate::define($permission->slug, function ($user) use ($permission) {
                return $user->roleHasPermission($permission->slug);
            });
        }
    }
}
