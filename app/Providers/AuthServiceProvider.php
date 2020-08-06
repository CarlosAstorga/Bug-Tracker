<?php

namespace App\Providers;

use App\File;
use App\Ticket;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * Middleware para rutas.
         */
        Gate::define('manage-users', function ($user) {
            return $user->hasRole('Administrador') ? Response::allow() : Response::deny('Autorizado solo a Administradores.');
        });

        Gate::define('manage-projects', function ($user) {
            return $user->hasAnyRoles(['Administrador', 'Lider de proyecto']) ? Response::allow() : Response::deny('Solo personal autorizado.');
        });

        Gate::define('is-author', function ($user, $post) {
            if ($user->is_admin) return true;
            return $user->id === $post->submitter_id || $user->id === $post->developer_id ? Response::allow() : Response::deny('Usuario no autorizado.');
        });

        Gate::define('download-file', function ($user, $file) {
            if ($user->is_admin) return true;
            return  $user->id == $file->ticket->submitter_id || $user->id == $file->ticket->developer_id ? Response::allow() : Response::deny('Usuario no autorizado.');
        });

        /**
         * Acciones.
         */

        Gate::define('assign-users', function ($user) {
            return $user->hasAnyRoles(['Administrador', 'Lider de proyecto']);
        });

        Gate::define('change-status', function ($user) {
            return $user->hasRole('Desarrollador');
        });
    }
}
