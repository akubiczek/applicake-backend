<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{

    protected $connection = 'tenant';

    protected $fillable = [
        'name',
        'notification_email',
        'is_general',
    ];

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function sources()
    {
        return $this->hasMany(Source::class);
    }

    public function templates()
    {
        return $this->hasMany(MessageTemplate::class);
    }

    protected $dispatchesEvents = [
//        'created' => \App\Events\RecruitmentWasStored::class,
    ];
}
