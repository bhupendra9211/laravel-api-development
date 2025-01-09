<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;  // Add this line

class DropDatabase extends Command
{
    protected $signature = 'db:drop';
    protected $description = 'Drop the entire database';

    public function handle()
    {
        $databaseName = env('DB_DATABASE');  // Get the database name from the .env file

        DB::statement("DROP DATABASE IF EXISTS {$databaseName}");

        $this->info("Database {$databaseName} has been dropped.");
    }
}
