<?php
namespace App\Utils;

use App\Models\Candidate;
use Illuminate\Support\Facades\Storage;

class CandidateDeleter
{
    public static function delete(Candidate $candidate)
    {
        Storage::delete(storage_path('app/' . $candidate->path_to_cv));
        $candidate->path_to_cv = '';
        $candidate->additional_info = '';
        self::hashData($candidate);
        $candidate->save();
        $candidate->delete();
    }

    public static function hashData(Candidate $candidate)
    {
        $candidate->first_name = sha1($candidate->first_name);
        $candidate->last_name = sha1($candidate->last_name);
        $candidate->email = sha1($candidate->email);
        $candidate->phone_number = sha1($candidate->phone_number);
    }
}
