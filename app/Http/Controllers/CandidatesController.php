<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Http\Requests\CandidatesListRequest;
use App\Http\Requests\ChangeStageRequest;
use App\Mail\ForwardCv;
use App\Repositories\CandidatesRepository;
use App\Repositories\RecruitmentsRepository;
use App\Utils\CandidateDeleter;
use App\Utils\PhoneFormatter;
use App\Utils\MessageService;
use App\Stage;
use Illuminate\Http\Request;

class CandidatesController extends Controller
{
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

        foreach ($candidates as $candidate) {
            $candidate->phone_number = PhoneFormatter::format($candidate->phone_number);
        }

        return response()->json($candidates);
    }

    public function get($candidateId)
    {
        $candidate = Candidate::with(['source', 'recruitment'])->find($candidateId);
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

    public function delete($candidateId)
    {
        $candidate = Candidate::find($candidateId);

        if ($candidate) {
            $messageSubject = 'Usunięcie kandydatury z bazy KISS digital';
            $messageBody = 'Informuję, że Pana/Pani dane oraz plik CV zostały usunięte z bazy rekrutacyjnej firmy KISS digital. Dziękuję za zgłoszenie i zachęcam do kandydowania w przyszłości - aktualne oferty pracy można znaleźć na stronie https://kissdigital.com/jobs.';
            MessageService::sendMessage($candidate, $messageSubject, $messageBody);
            CandidateDeleter::delete($candidate);

            return response()->json(null, 200);
        }

        return response()->json(null, 404);
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
        $candidate = Candidate::find($request->get('candidate_id'));

        if (!$candidate) {
            return response()->json(['error' => 'Candidate not found'], 404);
        }

        $stage = Stage::find($request->get('stage_id'));

        if (!$stage) {
            return response()->json(['error' => 'Stage not found'], 400);
        }

        $candidate->stage_id = $stage->id;
        $candidate->save();

        if ($request->send_message) {

            $delay = null;

            if ($request->delay_message_send) {
                $delay = $request->delayed_message_date;
            }

            MessageService::sendMessage($candidate, $request->get('message_subject'), $request->get('message_body'), $delay, $request->user());
            $notify[] = 'Wiadomość do kandydata została wysłana.';
        }

        return response()->json($candidate, 200, ['Location' => '/candidates/' . $candidate->id]);
    }
}
