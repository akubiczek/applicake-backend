<?php

namespace App;

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
