<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $connection = 'tenant';

    const TYPE_EMAIL = 1;
    const TYPE_SMS = 2;

    protected $dates = [
        'created_at',
        'updated_at',
        'scheduled_at'
    ];
}
