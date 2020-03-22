<?php
namespace App\Utils;

use App\Events\CandidateDeleted;
use App\Models\Candidate;
use Illuminate\Support\Facades\Storage;

class CandidateDeleter
{
    public static function deleteCandidate($candidateId)
    {
        $candidate = Candidate::findOrFail($candidateId);

        Storage::delete(storage_path('app/' . $candidate->path_to_cv));
        $candidate->path_to_cv = '';
        $candidate->additional_info = '';
        self::hashData($candidate);
        $candidate->save();

        $candidate->delete(); //safe since we use softdeletes

        event(new CandidateDeleted($candidate));
    }

    protected static function hashData(Candidate $candidate)
    {
        $candidate->first_name = sha1($candidate->first_name);
        $candidate->last_name = sha1($candidate->last_name);
        $candidate->email = sha1($candidate->email);
        $candidate->phone_number = sha1($candidate->phone_number);
    }
}
