<?php

namespace App\Utils\Recruitments;

use App\Recruitment;

class RecruitmentCreator
{
    public static function create(array $data): Recruitment
    {
        $recruitment = new Recruitment();
        $recruitment->name = $data['name'];
        $recruitment->job_title = $data['job_title'];
        $recruitment->save();

        return Recruitment::find($recruitment->id);
    }
}
