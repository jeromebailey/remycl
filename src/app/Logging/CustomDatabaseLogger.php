<?php
namespace App\Logging;

use Monolog\Handler\AbstractHandler;
use Illuminate\Support\Facades\DB;

class CustomDatabaseLogger extends AbstractHandler
{

    public function handle(array $record): bool
    {

        $data = [
            'controller' => $record['context']['controller'] ?? null,
            'function' => $record['context']['function'] ?? null,
            'message' => $record['message'],
            'stack_trace' => $record['context']['exception'] ?? null,
            'created_at' => $record['datetime']->format('Y-m-d H:i:s'),
        ];

        // Insert log data into the 'error_logs' table
        DB::table('error_logs')->insert($data);
        // Always return false to indicate that this handler processed the record
        return false;
    }
}

?>