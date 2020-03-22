<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{

    protected $connection = 'tenant';

    const STAGE_NEW = 1;
    const STAGE_CV_ANALYSIS = 2;

    public function candidates()
    {
        return $this->hasMany('App\Models\Candidate');
    }
}
