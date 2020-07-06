<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateDeleteRequest;
use App\Http\Requests\CandidatesCreateRequest;
use App\Http\Requests\CandidatesListRequest;
use App\Http\Requests\CandidateUpdateRequest;
use App\Http\Requests\ChangeStageRequest;
use App\Http\Resources\CandidateResource;
use App\Http\Resources\TruncatedCandidateResource;
use App\Models\Candidate;
use App\Repositories\CandidatesRepository;
use App\Services\TenantManager;
use App\Utils\Candidates\CandidateCreator;
use App\Utils\Candidates\CandidateDeleter;
use App\Utils\Candidates\CandidateUpdater;
use App\Utils\Candidates\StageChanger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CandidatesController extends Controller
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

    public function create(CandidatesCreateRequest $request)
    {
        $candidate = CandidateCreator::createCandidate($request, $this->tenantManager);
        return response()->json($candidate, 201);
    }

    public function list(CandidatesListRequest $request)
    {
        $recruitmentId = $request->get('recruitmentId');
        $user = Auth::user();

        if ($request->get('search')) {
            $candidates = CandidatesRepository::search($request->validated());
        } else if ($recruitmentId) {
            $candidates = Candidate::where('recruitment_id', $recruitmentId)->with('recruitment')->orderBy('created_at', 'DESC')->get();
        } else {
            $candidates = Candidate::with('recruitment')->orderBy('created_at', 'DESC')->get();
        }

        if (!$user->can('read all recruitments')) {
            $filtered = $candidates->filter(function ($candidate, $key) use ($user) {
                return $user->can('view', $candidate);
            }
            );

            $candidates = $filtered;
        }

        return TruncatedCandidateResource::collection($candidates);
    }

//    DEPRECATED
//    public function names(Request $request)
//    {
//        $search = $request->get('search');
//        $columns = ['id', 'name'];
//
//        if ($search) {
//            $candidates = CandidatesRepository::search(['search' => $search], $columns);
//        } else {
//            $candidates = Candidate::select($columns)->get();
//        }
//        return response()->json($candidates);
//    }

    public function get(Candidate $candidate)
    {
        return new CandidateResource($candidate);
    }

    public function update(CandidateUpdateRequest $request, Candidate $candidate)
    {
        $candidate = CandidateUpdater::updateCandidate($candidate->id, $request);
        return response()->json($candidate, 200, ['Location' => '/candidates/' . $candidate->id]);
    }

    public function delete(CandidateDeleteRequest $request, Candidate $candidate)
    {
        CandidateDeleter::deleteCandidate($request, $candidate->id);
        return response()->json(null, 200);
    }

    public function hasBeenSeen(Candidate $candidate)
    {
        if (!$candidate->seen_at) {
            $candidate->seen_at = new \DateTime();
            $candidate->save();
        }

        return response()->json($candidate, 200, ['Location' => '/candidates/' . $candidate->id]);
    }

    //TODO: route nie chroniony - docelowo zrobić zabezpieczenie z użyciem jednorazowych tokenów, a także nie przekazywać do klienta pola path_to_cv
    public function cv(Request $request, $candidateId)
    {
        $download = $request->get('download');
        $candidate = Candidate::find($candidateId);

        if (!Storage::disk('s3')->exists($candidate->path_to_cv)) {
            return response('File not found', 404);
        }

        $fileName = str_replace(' ', '_', $candidate->name) . '-CV.pdf'; //TODO sanitize

        if ($download) {
            return Storage::disk('s3')->download($candidate->path_to_cv, $fileName);
        } else {
            return Storage::disk('s3')->response($candidate->path_to_cv, $fileName);
        }
    }

    public function changeStage(ChangeStageRequest $request)
    {
        $candidate = StageChanger::changeStage($request);
        return response()->json($candidate, 200, ['Location' => '/candidates/' . $candidate->id]);
    }
}

