<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'position_info',
        'additional_info',
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
