<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidatesCreateRequest;
use App\Http\Resources\ApplyFormResource;
use App\Models\Source;
use App\Utils\Candidates\CandidateCreator;

class ApplyController extends Controller
{
    public function applyForm($sourceKey)
    {
        $source = Source::where('key', $sourceKey)->get()->first();

        if (empty($source))
            return response()->json(['message' => 'Recruitment not found'], 404);

        return new ApplyFormResource($source->recruitment);
    }

    public function apply(CandidatesCreateRequest $request)
    {
        $source = Source::where('key', $request->get('key'))->get()->first();
        if (empty($source))
            return response()->json(['message' => 'Recruitment not found'], 404);

        $candidate = CandidateCreator::createCandidate($request);
        return response()->json($candidate, 201);
    }
}
