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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Role::create(['title' => 'Administrador']);
        Role::create(['title' => 'Lider de proyecto']);
        Role::create(['title' => 'Desarrollador']);
        Role::create(['title' => 'Usuario']);
    }
}
