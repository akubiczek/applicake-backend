<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecruitmentCloseRequest;
use App\Http\Requests\RecruitmentCreateRequest;
use App\Http\Requests\RecruitmentUpdateRequest;
use App\Http\Resources\RecruitmentResource;
use App\Models\Recruitment;
use App\Models\Stage;
use App\Services\TenantManager;
use App\Utils\Recruitments\RecruitmentCreator;

class RecruitmentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param TenantManager $tenantManager
     * @return void
     */
    public function __construct(TenantManager $tenantManager)
    {
        RecruitmentResource::setTenantManager($tenantManager); //workaround - not the best but it works well
    }

    public function create(RecruitmentCreateRequest $request)
    {
        $recruitment = RecruitmentCreator::create($request->validated());
        return response()->json($recruitment);
    }

    public function list()
    {
        $recruitments = Recruitment::where('is_draft', false)->with('sources')->withCount(['candidates as new_candidates_count' => function ($query) {
            $query->whereNull('seen_at');
        }])->orderByDesc('created_at')->get();

        return RecruitmentResource::collection($recruitments);
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
        $recruitment = RecruitmentCreator::updateRecruitment($recruitmentId, $request);
        return response()->json($recruitment, 200);
    }

    public function close(RecruitmentCloseRequest $request, $recruitmentId)
    {
        $recruitment = RecruitmentCreator::close($recruitmentId, $request);
        return response()->json($recruitment, 200);
    }

    public function reopen($recruitmentId)
    {
        $recruitment = RecruitmentCreator::reopen($recruitmentId);
        return response()->json($recruitment, 200);
    }
}
