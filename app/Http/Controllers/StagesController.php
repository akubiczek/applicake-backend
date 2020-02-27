<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidatesIndexRequest;
use App\Http\Requests\CandidateUpdateRequest;
use App\Mail\ForwardCv;
use App\Repositories\RecruitmentsRepository;
use App\Services\CandidateDeleter;
use App\Services\MessagesService;
use App\Models\Stage;
use Illuminate\Http\Request;

class StagesController extends Controller
{
    public function list(Request $request)
    {
        $recruitmentId = $request->get('recruitmentId');

        if ($recruitmentId && false) {
            //TODO rozszerzyć funkcjonalność etapów
            $stages = Stage::where('recruitment_id', $recruitmentId)->orderBy('id', 'ASC')->get();
        } else {
            $stages = Stage::orderBy('id', 'ASC')->get();
        }

        return response()->json($stages);
    }
}
