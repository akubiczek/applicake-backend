<?php

namespace App\Http\Controllers;

use App\Events\CandidateApplied;
use App\Events\CandidateMoved;
use App\Events\CandidateRated;
use App\Http\Requests\CandidateDeleteRequest;
use App\Models\Candidate;
use App\Http\Requests\CandidatesCreateRequest;
use App\Http\Requests\CandidatesListRequest;
use App\Http\Requests\ChangeStageRequest;
use App\Http\Resources\CandidateCollection;
use App\Http\Resources\TruncatedCandidateResource;
use App\Repositories\CandidatesRepository;
use App\Repositories\RecruitmentsRepository;
use App\Utils\CandidateDeleter;
use App\Utils\Candidates\CandidateCreator;
use App\Utils\Candidates\StageChanger;
use App\Utils\MessageService;
use Illuminate\Http\Request;
use App\Http\Resources\CandidateResource;

class CandidatesController extends Controller
{
    public function create(CandidatesCreateRequest $request)
    {
        $candidate = CandidateCreator::create($request);

        if ($candidate) {
            event(new CandidateApplied($candidate));
            return response()->json($candidate, 201);
        }

        return response()->json(['status' => 'Recruitment not found'], 404);
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

    public function update(Request $request, $candidateId)
    {
        $candidate = Candidate::find($candidateId);

        if ($candidate) {

            if (isset($request->recruitment_id)) {
                event(new CandidateMoved($candidate, $candidate->recruitment_id, $request->recruitment_id));
                $candidate->recruitment_id = $request->recruitment_id;
            }

            if (isset($request->rate)) {
                event(new CandidateRated($candidate, $candidate->rate, $request->rate));
                $candidate->rate = $request->rate;
            }

            $candidate->save();
        }

        return response()->json($candidate, 200, ['Location' => '/candidates/' . $candidate->id]);
    }

    public function delete($candidateId)
    {
        CandidateDeleter::deleteCandidate($candidateId);
        return response()->json(null, 200);
    }

    //TODO: route nie chroniony - docelowo zrobić zabezpieczenie z użyciem jednorazowych tokenów, a także nie przekazywać do klienta pola path_to_cv
    public function cv(Request $request, $candidateId)
    {
        $download = $request->get('download');
        $candidate = Candidate::find($candidateId);

        if ($download) {
            return response()->download(storage_path('app/' . $candidate->path_to_cv), $candidate->first_name . '_' . $candidate->last_name . '-CV.pdf');
        } else {
            return response()->file(storage_path('app/' . $candidate->path_to_cv));
        }
    }

    public function changeStage(ChangeStageRequest $request)
    {
        $candidate = StageChanger::changeStage($request);
        return response()->json($candidate, 200, ['Location' => '/candidates/' . $candidate->id]);
    }
}

