<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    const TYPE_EMAIL = 1;
    const TYPE_SMS = 2;

    protected $dates = [
        'created_at',
        'updated_at',
        'scheduled_at'
    ];
}
