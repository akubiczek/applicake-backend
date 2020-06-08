<?php

namespace App\Utils\Candidates;

use App\Http\Requests\CandidatesCreateRequest;
use App\Models\Candidate;
use App\Models\Recruitment;
use App\Models\Source;
use App\Services\TenantManager;
use App\Utils\StageHelper;

class CandidateCreator
{
    public static function createCandidate(CandidatesCreateRequest $request, TenantManager $tenantManager)
    {
        $key = $request->get('key');

        if (!empty($key)) {
            $source = Source::where('key', $key)->firstOrFail();
            if ($source) {
                $recruitment = $source->recruitment;
            }
        } else {
            //TODO podanie rectruitment_id powinno być dozwolone tylko z poziomu panelu, a nie publicznej rekrutacji
            $recruitment_id = $request->get('recruitment_id');
            $recruitment = Recruitment::find($recruitment_id);
        }

        if (empty($recruitment)) {
            return false; //TODO walidacja powinna być wyżej (chyba chodzilo mi o to, ze gdzies na poziomie requestu albo controllera)
        }

        if ($request->file) {
            $path_to_cv = $request->file->store($tenantManager->getTenant()->subdomain . '/' . $recruitment->id, 's3');
        } else {
            $path_to_cv = '';
        }

        $candidate = new Candidate();
        $candidate->name = $request->get('name');
        $candidate->email = $request->get('email');
        $candidate->phone_number = $request->get('phone_number');
        $candidate->future_agreement = (bool)data_get($request->validated(), 'future_agreement');
        $candidate->source_recruitment_id = $request->get('source_recruitment_id');
        $candidate->stage_id = StageHelper::getFirstStage($recruitment->id)->id;
        $candidate->path_to_cv = $path_to_cv;
        $candidate->source_id = !empty($source) ? $source->id : null;
        $candidate->recruitment_id = $recruitment->id;

        $customData = [];
        foreach ($recruitment->formFields as $field) {
            if (!$field->system) {
                $customData[] = ['id' => $field->id, 'label' => $field->label, 'value' => $request->get($field->name)];
            }
        }
        $candidate->custom_fields = json_encode($customData);

        $candidate->save();
        $candidate = Candidate::find($candidate->id);

        return $candidate;
    }

    public static function fakeCandidate($recruitment)
    {
        $candidate = new Candidate();
        $candidate->name = 'Jan Nowak';
        $candidate->email = 'jan.nowak@example.com';
        $candidate->phone_number = '+48 600 600 600';
        $candidate->future_agreement = false;
        $candidate->recruitment_id = $recruitment->id;

        return $candidate;
    }
}
