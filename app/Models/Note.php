<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $connection = 'tenant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['candidate_id', 'user_id', 'body'];

    public function candidate()
    {
        return $this->belongsTo('App\Models\Candidate');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
    }
}
