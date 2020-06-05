<?php

namespace App\Http\Controllers;

use App\Events\CandidateApplied;
use App\Http\Requests\CandidatesCreateRequest;
use App\Http\Resources\ApplyFormResource;
use App\Models\Source;
use App\Services\TenantManager;
use App\Utils\Candidates\CandidateCreator;

class ApplyController extends Controller
{
    protected $tenantManager;

    /**
     * Create a new controller instance.
     *
     * @param TenantManager $tenantManager
     * @return void
     */
    public function __construct(TenantManager $tenantManager)
    {
        $this->tenantManager = $tenantManager;
    }

    public function applyForm($sourceKey)
    {
        $source = Source::where('key', $sourceKey)->with('recruitment.formFields')->get()->first();

        if (empty($source))
            return response()->json(['message' => 'Recruitment not found'], 404);

        return new ApplyFormResource($source->recruitment);
    }

    public function apply(CandidatesCreateRequest $request)
    {
        $source = Source::where('key', $request->get('key'))->get()->first();
        if (empty($source))
            return response()->json(['message' => 'Recruitment not found'], 404);

        $candidate = CandidateCreator::createCandidate($request, $this->tenantManager);
        event(new CandidateApplied($candidate));
        return response()->json($candidate, 201);
    }
}
