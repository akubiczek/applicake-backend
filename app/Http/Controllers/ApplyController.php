<?php

namespace App\Http\Controllers;

use App\Events\CandidateApplied;
use App\Http\Requests\CandidatesApplyRequest;
use App\Http\Resources\ApplyFormResource;
use App\Jobs\ProcessResume;
use App\Jobs\StoreUploadedFile;
use App\Models\Source;
use App\Services\TenantManager;
use App\Utils\Candidates\CandidateCreator;

class ApplyController extends Controller
{
    /**
     * @var TenantManager
     */
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

    public function apply(CandidatesApplyRequest $request)
    {
        $source = Source::where('key', $request->get('key'))->get()->first();
        if (empty($source))
            return response()->json(['message' => 'Recruitment not found'], 404);

        $candidate = CandidateCreator::createFromApplyRequest($request, $this->tenantManager);

        StoreUploadedFile::withChain([new ProcessResume($candidate)])->dispatch($candidate->path_to_cv);
        event(new CandidateApplied($candidate));
        return response()->json($candidate, 201);
    }
}
