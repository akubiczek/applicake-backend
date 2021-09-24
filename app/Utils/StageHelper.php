<?php

namespace App\Utils;

use App\Models\Stage;

class StageHelper
{
    public static function getFirstStage($recruitment_id)
    {
        return Stage::where('recruitment_id', $recruitment_id)->orderBy('order')->first();
    }
}
