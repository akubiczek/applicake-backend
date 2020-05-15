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
use App\Utils\Candidates\CandidateCreator;
use App\Utils\Candidates\CandidateDeleter;
use App\Utils\Candidates\CandidateUpdater;
use App\Utils\Candidates\StageChanger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidatesController extends Controller
{
    public function create(CandidatesCreateRequest $request)
    {
        $candidate = CandidateCreator::createCandidate($request);
        return response()->json($candidate, 201);
    }

    public function list(CandidatesListRequest $request)
    {
        $recruitmentId = $request->get('recruitmentId');

        if ($request->get('search')) {
            $candidates = CandidatesRepository::search($request->validated());
        } else if ($recruitmentId) {
            $candidates = Candidate::where('recruitment_id', $recruitmentId)->with('recruitment')->orderBy('created_at', 'DESC')->get();
        } else {
            $candidates = Candidate::with('recruitment')->orderBy('created_at', 'DESC')->get();
        }

        return TruncatedCandidateResource::collection($candidates);
    }

    public function names(Request $request)
    {
        $search = $request->get('search');
        $columns = ['id', 'first_name', 'last_name'];

        if ($search) {
            $candidates = CandidatesRepository::search(['search' => $search], $columns);
        } else {
            $candidates = Candidate::select($columns)->get();
        }
        return response()->json($candidates);
    }

    public function get($candidateId)
    {
        return new CandidateResource(Candidate::find($candidateId));
    }

    public function update(CandidateUpdateRequest $request, $candidateId)
    {
        $candidate = CandidateUpdater::updateCandidate($candidateId, $request);
        return response()->json($candidate, 200, ['Location' => '/candidates/' . $candidate->id]);
    }

    public function delete(CandidateDeleteRequest $request, $candidateId)
    {
        CandidateDeleter::deleteCandidate($request, $candidateId);
        return response()->json(null, 200);
    }

    public function hasBeenSeen($candidateId)
    {
        $candidate = Candidate::findOrFail($candidateId);
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

        $fileName = $candidate->first_name . '_' . $candidate->last_name . '-CV.pdf';

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

