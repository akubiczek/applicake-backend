<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecruitmentCloseRequest;
use App\Http\Requests\RecruitmentCreateRequest;
use App\Http\Requests\RecruitmentUpdateRequest;
use App\Models\Recruitment;
use App\Models\Stage;
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
        }])->orderByDesc('created_at')->get();
        return response()->json($recruitments);
    }

    public function get($recruitmentId)
    {
        $recruitment = Recruitment::findOrFail($recruitmentId);
        //TODO: nie obsługujemy jeszcze osobnych etapów dla różnych rekrutacji
        $recruitment->stages = Stage::orderBy('id', 'ASC')->get();

        return response()->json($recruitment);
    }

    public function update(RecruitmentUpdateRequest $request, $recruitmentId)
    {
        $field = RecruitmentCreator::updateRecruitment($recruitmentId, $request);
        return response()->json($field, 200);
    }

    public function close(RecruitmentCloseRequest $request, $recruitmentId)
    {
        $field = RecruitmentCreator::close($recruitmentId, $request);
        return response()->json($field, 200);
    }
}
