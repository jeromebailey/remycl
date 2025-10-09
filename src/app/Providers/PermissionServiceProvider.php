<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

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
        if( $this->canLoadPermissions() ){
            $this->defineGates();
        }
    }

    private function canLoadPermissions()
    {
        try {
            if ($this->app->runningInConsole()) {
                return false;
            }
            return Schema::hasTable('permissions');
        } catch (\Exception $e) {
            return false;
        }
    }

    private function defineGates()
    {
        try{
            $permissions = Cache::remember('permissions', 3600, function () {
                return Permission::all();
            });

            foreach ($permissions as $permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->roleHasPermission($permission->slug);
                });
            }
        } catch (\Exception $e) {
            Log::warning('Could not load permissions: ' . $e->getMessage());
        }
    }
}
