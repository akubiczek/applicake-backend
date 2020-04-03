<?php

namespace App\Http\Controllers;

use App\Http\Requests\SourceCreateRequest;
use App\Http\Resources\SourceResource;
use App\Models\Source;
use App\Utils\SourceCreator;
use Illuminate\Http\Request;

class SourcesController extends Controller
{
    public function list(Request $request)
    {
        $recruitmentId = $request->get('recruitment_id');

        if ($recruitmentId) {
            $sources = Source::where('recruitment_id', $recruitmentId)->orderBy('created_at', 'DESC')->get();
        } else {
            $sources = Source::orderBy('created_at', 'DESC')->get();
        }
        
        return response()->json($sources);
    }

    public function create(SourceCreateRequest $request)
    {
        $source = SourceCreator::create($request->validated());
        return new SourceResource($source);
    }
}
