<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormField extends Model
{
    use SoftDeletes;

    const TYPE_STRING = 1;

    protected $connection = 'tenant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['recruitment_id', 'name', 'type', 'required'];

    public function recruitment()
    {
        return $this->belongsTo(Recruitment::class);
    }
}
