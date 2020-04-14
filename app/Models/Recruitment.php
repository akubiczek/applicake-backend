<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    const STATE_PUBLISHED = 0;
    const STATE_FINISHED = 1;
    const STATE_CLOSED = 2;

    protected $connection = 'tenant';

    protected $fillable = [
        'name',
        'notification_email',
        'is_general',
        'is_draft',
    ];

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function sources()
    {
        return $this->hasMany(Source::class);
    }

    public function predefinedMessages()
    {
        return $this->hasMany(PredefinedMessage::class);
    }

    public function formFields()
    {
        return $this->hasMany(FormField::class);
    }

    protected $dispatchesEvents = [
//        'created' => \App\Events\RecruitmentWasStored::class,
    ];
}
