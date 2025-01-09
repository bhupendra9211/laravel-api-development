<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Command
{
    protected $signature = 'db:create';
    protected $description = 'Create the database if it does not exist';

    public function handle()
    {
        $databaseName = env('DB_DATABASE');  // Get the database name from the .env file

        DB::statement("CREATE DATABASE IF NOT EXISTS {$databaseName}");

        $this->info("Database {$databaseName} has been created or already exists.");
    }
}
