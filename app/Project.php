<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'description'
    ];

    protected $casts = [
        'created_at' => 'date:d/m/Y H:i',
        'updated_at' => 'date:d/m/Y H:i'
    ];

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function users()
    {
        return $this->belongsToMany("App\User");
    }
}
