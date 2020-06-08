<?php

namespace App\Utils\Recruitments;

use App\Http\Requests\RecruitmentCloseRequest;
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

        self::seedData($recruitment);
        return Recruitment::with('sources')->with('predefinedMessages')->where('id', $recruitment->id)->get()->first();
    }

    private static function seedData(Recruitment $recruitment)
    {
        SourceCreator::create(['recruitment_id' => $recruitment->id, 'name' => self::defaultSourceName()]);

        \StagesSeeder::connection('tenant')->setRecruitment($recruitment)->run();
        \PredefinedMessagesSeeder::connection('tenant')->setRecruitment($recruitment)->run();
        \FormFieldsSeeder::connection('tenant')->setRecruitment($recruitment)->run();
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

    public static function close($recruitmentId, RecruitmentCloseRequest $request)
    {
        $recruitment = Recruitment::findOrFail($recruitmentId);
        $recruitment->state = $request->get('keep_form_open') ? Recruitment::STATE_FINISHED : Recruitment::STATE_CLOSED;
        $recruitment->save();

        return $recruitment;
    }

    public static function reopen($recruitmentId)
    {
        $recruitment = Recruitment::findOrFail($recruitmentId);
        $recruitment->state = Recruitment::STATE_PUBLISHED;
        $recruitment->save();

        return $recruitment;
    }
}
