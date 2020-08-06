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
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Priority::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Priority::create(['title' => 'Baja']);
        Priority::create(['title' => 'Media']);
        Priority::create(['title' => 'Alta']);
    }
}
