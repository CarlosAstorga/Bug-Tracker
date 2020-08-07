<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $appends = ['join_roles', 'highest_role', 'is_admin'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'date:d/m/Y',
        'updated_at' => 'date:d/m/Y'
    ];

    protected $with = [
        'roles'
    ];

    public function roles()
    {
        return $this->belongsToMany("App\Role");
    }

    public function hasAnyRoles($roles)
    {
        if ($this->roles()->whereIn('title', $roles)->first()) {
            return true;
        }

        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('title', $role)->first()) {
            return true;
        }

        return false;
    }

    public function getJoinRolesAttribute()
    {
        return $this->roles()->pluck('title')->join(" / ");
    }

    public function getHighestRoleAttribute()
    {
        return $this->roles()->orderBy('role_id')->first()->title;
    }

    public function getIsAdminAttribute()
    {
        return $this->hasRole('Administrador');
    }

    public function photo()
    {
        if (file_exists(public_path("images/{$this->avatar}"))) {
            return "/images/{$this->avatar}";
        } else {
            return '/images/avatar.png';
        }
    }
}
