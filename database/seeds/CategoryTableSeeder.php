<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET session_replication_role = 'replica';");
        Category::truncate();
        DB::statement("SET session_replication_role = 'origin';");

        Category::create(['title' => 'Bugs / Errores']);
        Category::create(['title' => 'Retroalimentación']);
        Category::create(['title' => 'Nueva función']);
        Category::create(['title' => 'Otro']);
    }
}
