<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'message', 'ticket_id'
    ];

    protected $with = [
        'submitter'
    ];

    public function submitter()
    {
        return $this->hasOne('App\User', 'id', 'user_id')
            ->select('id', 'name');
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('d/m/Y g:i:s');
    }
}
