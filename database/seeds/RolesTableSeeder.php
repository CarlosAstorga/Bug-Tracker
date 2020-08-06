<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET session_replication_role = 'replica';");
        Role::truncate();
        DB::statement("SET session_replication_role = 'origin';");

        Role::create(['title' => 'Administrador']);
        Role::create(['title' => 'Lider de proyecto']);
        Role::create(['title' => 'Desarrollador']);
        Role::create(['title' => 'Usuario']);
    }
}
