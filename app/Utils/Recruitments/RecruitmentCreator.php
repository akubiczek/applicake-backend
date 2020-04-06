<?php

namespace App\Utils\Recruitments;

use App\Http\Requests\RecruitmentUpdateRequest;
use App\Models\Recruitment;
use App\Utils\SourceCreator;

class RecruitmentCreator
{
    const DEFAULT_SOURCE_NAME = 'Corporate website';

    public static function create(array $data): Recruitment
    {
        $recruitment = new Recruitment();
        $recruitment->name = $data['name'];
        $recruitment->job_title = $data['job_title'];
        $recruitment->notification_email = $data['notification_email'];
        $recruitment->is_draft = $data['is_draft'] ?? true;
        $recruitment->save();

        SourceCreator::create(['recruitment_id' => $recruitment->id, 'name' => self::defaultSourceName()]);

        return Recruitment::find($recruitment->id);
    }

    public static function defaultSourceName()
    {
        return self::DEFAULT_SOURCE_NAME;
    }

    public static function updateRecruitment($recruitmentId, RecruitmentUpdateRequest $request)
    {
        $recruitment = Recruitment::findOrFail($recruitmentId);
        $input = $request->validated();
        $recruitment->fill($input)->save();

        return $recruitment;
    }
}
