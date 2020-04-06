<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecruitmentCreateRequest;
use App\Http\Requests\RecruitmentUpdateRequest;
use App\Models\Recruitment;
use App\Models\Source;
use App\Utils\Recruitments\RecruitmentCreator;

class RecruitmentsController extends Controller
{
    public function create(RecruitmentCreateRequest $request)
    {
        $recruitment = RecruitmentCreator::create($request->validated());
        return response()->json($recruitment);
    }

    public function list()
    {
        $recruitments = Recruitment::where('is_draft', false)->withCount(['candidates', 'candidates as new_candidates_count' => function ($query) {
            $query->where('stage_id', 1);
        }])->get();
        return response()->json($recruitments);
    }

    public function get($recruitmentId)
    {
        return response()->json(Recruitment::find($recruitmentId));
    }

    public function getByKey($key)
    {
        $source = Source::where('key', $key)->get()->first();

        if (empty($source))
            return response()->json(['message'=>'Recruitment not found'], 404);

        return response()->json(['job_title' => $source->recruitment->name]); //TODO return job_title instead of name
    }
}
