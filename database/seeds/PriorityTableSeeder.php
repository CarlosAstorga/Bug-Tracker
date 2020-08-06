<?php

use App\Priority;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriorityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement("SET session_replication_role = 'replica';");
        // Priority::truncate();
        // DB::statement("SET session_replication_role = 'origin';");

        Priority::create(['title' => 'Baja']);
        Priority::create(['title' => 'Media']);
        Priority::create(['title' => 'Alta']);
    }
}
