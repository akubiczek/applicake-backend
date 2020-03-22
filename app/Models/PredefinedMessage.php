<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PredefinedMessage extends Model
{
    const TYPE_STAGECHANGE = 0;
    const TYPE_DELETENOTIFICATION = 1;

    protected $connection = 'tenant';

    protected $fillable = [
        'subject',
        'body',
        'type',
        'stage_id',
        'recruitment_id',
    ];
}
