<?php
namespace App\Utils\Candidates;

use App\Events\CandidateDeleted;
use App\Http\Requests\CandidateDeleteRequest;
use App\Models\Candidate;
use Illuminate\Support\Facades\Storage;

class CandidateDeleter
{
    public static function deleteCandidate(CandidateDeleteRequest $request, $candidateId)
    {
        $candidate = Candidate::findOrFail($candidateId);

        $notificationEmailAddress = null;
        if ($request->get('notify_candidate')) {
            $notificationEmailAddress = $candidate->email;
        }

        Storage::delete(storage_path('app/' . $candidate->path_to_cv));
        $candidate->path_to_cv = '';
        self::hashData($candidate);
        $candidate->save();

        $candidate->delete(); //safe since we use softdeletes

        event(new CandidateDeleted($candidate, $notificationEmailAddress));
    }

    protected static function hashData(Candidate $candidate)
    {
        $candidate->name = sha1($candidate->first_name);
        $candidate->email = sha1($candidate->email);
        $candidate->phone_number = sha1($candidate->phone_number);
    }
}
