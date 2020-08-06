<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'file', 'uploader_id', 'notes', 'ticket_id'
    ];

    protected $with = [
        'uploader'
    ];

    public function uploader()
    {
        return $this->hasOne('App\User', 'id', 'uploader_id')
            ->select('id', 'name');
    }

    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('d/m/Y g:i:s');
    }
}
