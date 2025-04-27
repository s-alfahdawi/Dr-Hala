<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PatientSqlSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/sql/patients.sql');
        $sql = File::get($path);
        DB::unprepared($sql);
    }
}