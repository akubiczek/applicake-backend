<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PredefinedMessage extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'subject',
        'body',
        'type',
        'stage_id',
        'recruitment_id',
    ];

    public function recruitment()
    {
        return $this->belongsTo(Recruitment::class);
    }
}
