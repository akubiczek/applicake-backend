<?php

namespace App\Services;

use App\Models\Recruitment;

abstract class RecruitmentAwareSeeder extends TenantAwareSeeder
{
    /**
     * The name of the default connection.
     *
     * @var Recruitment
     */
    protected $recruitment;

    /**
     * @param Recruitment $recruitment
     */
    public function setRecruitment(Recruitment $recruitment): RecruitmentAwareSeeder
    {
        $this->recruitment = $recruitment;

        return $this;
    }
}
