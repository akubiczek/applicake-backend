<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{

    protected $connection = 'tenant';

    protected $fillable = [
        'subject',
        'body',
        'type',
        'stage_id',
        'recruitment_id',
    ];
}
