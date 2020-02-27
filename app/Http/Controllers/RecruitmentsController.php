<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecruitmentCreateRequest;
use App\Http\Requests\RecruitmentUpdateRequest;
use App\Recruitment;
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
        $recruitments = Recruitment::withCount(['candidates', 'candidates as new_candidates_count' => function ($query) {
            $query->where('stage_id', 1);
        }])->get();
        return response()->json($recruitments);
    }

    public function get($recruitmentId)
    {
        return response()->json(Recruitment::find($recruitmentId));
    }
}
