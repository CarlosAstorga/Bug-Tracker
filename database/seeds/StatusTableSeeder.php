<?php

use App\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET session_replication_role = 'replica';");
        Status::truncate();
        DB::statement("SET session_replication_role = 'origin';");

        Status::create(['title' => 'Abierto']);
        Status::create(['title' => 'Pendiente']);
        Status::create(['title' => 'Resuelto']);
        Status::create(['title' => 'Cerrado']);
    }
}
