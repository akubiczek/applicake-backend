<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $connection = 'tenant';

    public function candidate()
    {
        return $this->belongsTo('App\Models\Candidate');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
