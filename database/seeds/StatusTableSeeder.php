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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Status::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Status::create(['title' => 'Abierto']);
        Status::create(['title' => 'Pendiente']);
        Status::create(['title' => 'Resuelto']);
        Status::create(['title' => 'Cerrado']);
    }
}
