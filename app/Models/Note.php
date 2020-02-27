<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public function source()
    {
        return $this->belongsTo('App\Candidate');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}