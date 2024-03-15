<?php

namespace App\Providers;

//use App\Models\Submission;
use App\Observers\SubmisionObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        // if ($this->app->environment() !== 'production') {
        //     $this->app->register(\Way\Generators\GeneratorsServiceProvider::class);
        //     $this->app->register(\Xethron\MigrationsGenerator\MigrationsGeneratorServiceProvider::class);
        // }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Paginator::useBootstrap();
        //Submission::observe(SubmisionObserver::class);
        // if (config('app.first_run')) {
        //     Artisan::call('initialize:db');
        //     // After running the setup command, set the flag to false
        //     file_put_contents(base_path('.env'), str_replace(
        //         'APP_FIRST_RUN=true',
        //         'APP_FIRST_RUN=false',
        //         file_get_contents(base_path('.env'))
        //     ));
        // }
    }
}
