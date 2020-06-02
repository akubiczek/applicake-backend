<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use SoftDeletes;

    protected $connection = 'tenant';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'recruitment_id',
    ];

    public function recruitment()
    {
        return $this->belongsTo(Recruitment::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Scope a query to only include unseen candidates.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnseen($query)
    {
        return $query->where('stage_id', '=', Stage::STAGE_NEW);
    }
}
