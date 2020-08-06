<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $with = [
        'submitter',
        'priority',
        'status',
        'category',
        'developer',
        'project',
        'files',
        'comments'
    ];
    protected $fillable = [
        'title',
        'description',
        'submitter_id',
        'priority_id',
        'status_id',
        'category_id',
        'project_id',
        'developer_id',
    ];

    public function submitter()
    {
        return $this->hasOne('App\User', 'id', 'submitter_id')
            ->select('id', 'name');;
    }

    public function priority()
    {
        return $this->hasOne('App\Priority', 'id', 'priority_id')
            ->select('id', 'title');
    }

    public function status()
    {
        return $this->hasOne('App\Status', 'id', 'status_id')
            ->select('id', 'title');
    }

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id')
            ->select('id', 'title');
    }

    public function developer()
    {
        return $this->hasOne('App\User', 'id', 'developer_id')
            ->select('id', 'name');
    }

    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id')
            ->select('id', 'title');
    }

    public function files()
    {
        return $this->hasMany('App\File', 'ticket_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'ticket_id', 'id');
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('d/m/Y g:i:s');
    }
}
