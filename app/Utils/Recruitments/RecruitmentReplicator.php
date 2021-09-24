<?php

namespace App\Utils\Recruitments;

use App\Models\Recruitment;
use App\Utils\SourceCreator;
use Illuminate\Database\Eloquent\Model;

class RecruitmentReplicator
{
    protected static $relationships = [
        'formFields',
        'sources',
        'predefinedMessages',
    ];

    public static function duplicate($recruitmentId)
    {
        $recruitment = Recruitment::with(static::$relationships)->findOrFail($recruitmentId);

        $newRecruitment = $recruitment->replicate()->setRelations([]);
        $newRecruitment->name = $newRecruitment->name.' '.date('d.m.Y');
        $newRecruitment->is_draft = true;
        $newRecruitment->push();

        $replicatedOrder = static::replicateRelations($recruitment, $newRecruitment);

        return $replicatedOrder->loadMissing(static::$relationships);
    }

    protected static function replicateRelations(Model $oldModel, Model &$newModel)
    {
        foreach ($oldModel->getRelations() as $relation => $modelCollection) {

//            if (!in_array($relation, static::$relationships)) {
//                continue;
//            }

            foreach ($modelCollection as $model) {
                if ($relation === 'sources') {
                    SourceCreator::create(['name' => $model->name, 'recruitment_id' => $newModel->id]);
                } else {
                    $childModel = $model->replicate();
                    $childModel->recruitment_id = $newModel->id;
                    $childModel->push();
                }

                //$childModel->setRelations([]);
                //$newModel->{$relation}()->save($childModel); // saving whatever columns $childModel has except foreign keys relative to it's parent model. If there were any other foreign keys other than the parent model, in this case, those scenarios are not handled.
                //static::replicateRelations($model,$childModel);
            }
        }

        return $newModel;
    }
}
