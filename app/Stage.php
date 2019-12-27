<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    const STAGE_NEW = 1;
    const STAGE_CV_ANALYSIS = 2;

    public function candidates()
    {
        return $this->hasMany('App\Candidate');
    }
}
