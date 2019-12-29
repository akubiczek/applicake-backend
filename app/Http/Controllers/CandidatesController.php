<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Http\Requests\CandidatesIndexRequest;
use App\Http\Requests\CandidateUpdateRequest;
use App\Mail\ForwardCv;
use App\Repositories\CandidatesRepository;
use App\Repositories\RecruitmentsRepository;
use App\Services\CandidateDeleter;
use App\Utils\PhoneFormatter;
use App\MessageTemplate;
use App\Utils\MessagesService;
use App\Stage;
use Illuminate\Http\Request;

class CandidatesController extends Controller
{
    public function list(Request $request)
    {
//        $validated = $request->validated();
//
//        $candidates = $this->repository
//            ->getIndex($validated);
//
//        if ($request->get('search') && $candidates->count() === 1) {
//            return redirect(route('candidates.view', ['id' => $candidates->first()->id]));
//        }


        $recruitmentId = $request->get('recruitmentId');

        if ($recruitmentId) {
            $candidates = Candidate::where('recruitment_id', $recruitmentId)->with('recruitment')->orderBy('created_at', 'DESC')->get();
        } else {
            $candidates = Candidate::with('recruitment')->orderBy('created_at', 'DESC')->get();
        }

        foreach ($candidates as $candidate) {
            $candidate->phone_number = PhoneFormatter::format($candidate->phone_number);
        }

        return response()->json($candidates);
    }

    public function get($candidateId)
    {
        $candidate = Candidate::with(['source','recruitment'])->find($candidateId);
        $candidate->otherApplications = CandidatesRepository::getOtherApplications($candidate);
        $candidate->phone_number = PhoneFormatter::format($candidate->phone_number);
        return response()->json($candidate);
    }

    public function update(Request $request, $candidateId)
    {
        $candidate = Candidate::find($candidateId);

        if ($candidate) {

            if (isset($request->recruitment_id))
                $candidate->recruitment_id = $request->recruitment_id;

            if (isset($request->rate))
                $candidate->rate = $request->rate;

            $candidate->save();
        }

        return response()->json($candidate, 200, ['Location' => '/candidates/' . $candidate->id]);
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

    public function changeStage(Request $request, $candidateId)
    {
        $candidate = Candidate::find($candidateId);

        if (!$candidate) {
            return response()->json(null, 404);
        }

        $stage = Stage::find($request->get('stage_id'));

        if (!$stage) {
            return response()->json(null, 400);
        }

        $candidate->stage_id = $stage->id;
        $candidate->save();

        if ($request->send_message == 1) {
            $messageTemplate = new MessageTemplate;
            $messageTemplate->subject = $request->subject;
            $messageTemplate->body = $request->body;

            $delay = [
                'condition' => $request->delay_sending_message,
                'date' => $request->delay_datepicker,
                'time' => $request->delay_timepicker,
            ];

            MessagesService::sendMessage($candidate, $messageTemplate, $delay, $request->user());
            $notify[] = 'Wiadomość do kandydata została wysłana.';
        }

        return response()->json($candidate, 200, ['Location' => '/candidates/' . $candidate->id]);
    }
}
