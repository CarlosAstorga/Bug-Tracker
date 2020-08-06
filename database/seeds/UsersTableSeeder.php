<?php

use App\Comment;
use App\File;
use App\Project;
use App\Role;
use App\Ticket;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Project::truncate();
        Ticket::truncate();
        File::truncate();
        Comment::truncate();
        DB::table('project_user')->truncate();
        DB::table('role_user')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $adminRole = Role::where('title', 'Administrador')->first();
        $developerRole = Role::where('title', 'Desarrollador')->first();
        $userRole = Role::where('title', 'Usuario')->first();

        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'avatar' => 'avatar.png'
        ]);

        $manager = User::create([
            'name' => 'Lider P.',
            'email' => 'manager@manager.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'avatar' => 'avatar.png'
        ]);

        $developer = User::create([
            'name' => 'Desarrollador',
            'email' => 'developer@developer.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'avatar' => 'avatar.png'
        ]);

        $user = User::create([
            'name' => 'Usuario',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'avatar' => 'avatar.png'
        ]);



        $admin->roles()->attach($adminRole);
        $manager->roles()->attach($userRole);
        $developer->roles()->attach($developerRole);
        $user->roles()->attach($userRole);

        // factory(App\User::class, 50)->create()->each(function ($user) {
        //     $user->roles()->attach(random_int(2, 4));
        // });

        // factory(App\Project::class, 50)->create();
        // factory(App\Ticket::class, 50)->create();
    }
}
