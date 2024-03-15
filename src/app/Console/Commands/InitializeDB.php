<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitializeDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //return 0;
        // $this->call('migrate'); // Run migrations
        // $this->call('db:seed'); // Run seeders
        
        // $this->info('Application setup completed!');
    }
}
