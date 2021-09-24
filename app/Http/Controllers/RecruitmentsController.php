<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecruitmentCloseRequest;
use App\Http\Requests\RecruitmentCreateRequest;
use App\Http\Requests\RecruitmentUpdateRequest;
use App\Http\Resources\RecruitmentResource;
use App\Models\Recruitment;
use App\Services\TenantManager;
use App\Utils\Recruitments\RecruitmentCreator;
use App\Utils\Recruitments\RecruitmentReplicator;
use Illuminate\Support\Facades\Auth;

class RecruitmentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param TenantManager $tenantManager
     *
     * @return void
     */
    public function __construct(TenantManager $tenantManager)
    {
        RecruitmentResource::setTenantManager($tenantManager); //workaround - not the best but it works well
    }

    public function create(RecruitmentCreateRequest $request)
    {
        $user = Auth::user();
        if ($user->can('create recruitments')) {
            $recruitment = RecruitmentCreator::create($request->validated());

            return response()->json($recruitment);
        }

        return response('Unauthorized', 401);
    }

    public function list()
    {
        $user = Auth::user();
        if ($user->can('read all recruitments')) {
            $recruitments = Recruitment::where('is_draft', false)->with('sources')->withCount(['candidates as new_candidates_count' => function ($query) {
                $query->whereNull('seen_at');
            }])->orderByDesc('created_at')->get();
        } else {
            $recruitments = $user->grantedRecruitments()->where('is_draft', false)->with('sources')->withCount(['candidates as new_candidates_count' => function ($query) {
                $query->whereNull('seen_at');
            }])->orderByDesc('created_at')->get();
        }

        return RecruitmentResource::collection($recruitments);
    }

    public function get(Recruitment $recruitment)
    {
        return response()->json($recruitment->load('stages'));
    }

    public function update(RecruitmentUpdateRequest $request, Recruitment $recruitment)
    {
        $recruitment = RecruitmentCreator::updateRecruitment($recruitment->id, $request);

        return response()->json($recruitment, 200);
    }

    public function close(RecruitmentCloseRequest $request, Recruitment $recruitment)
    {
        $recruitment = RecruitmentCreator::close($recruitment->id, $request);

        return response()->json($recruitment, 200);
    }

    public function reopen(Recruitment $recruitment)
    {
        $recruitment = RecruitmentCreator::reopen($recruitment->id);

        return response()->json($recruitment, 200);
    }

    public function duplicate(Recruitment $recruitment)
    {
        $recruitment = RecruitmentReplicator::duplicate($recruitment->id);

        return response()->json($recruitment, 200);
    }
}
