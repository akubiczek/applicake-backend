<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidatesIndexRequest;
use App\Models\Stage;
use App\Repositories\RecruitmentsRepository;
use App\Services\CandidateDeleter;
use App\Services\MessagesService;
use Illuminate\Http\Request;

class StagesController extends Controller
{
    public function list(Request $request)
    {
        $recruitmentId = $request->get('recruitment_id');

        if ($recruitmentId) {
            $stages = Stage::where('recruitment_id', $recruitmentId)->orderBy('order', 'ASC')->get();
            foreach ($stages as $stage) {
                $stage->recruitment_id = intval($recruitmentId);
            }
        } else {
            $stages = Stage::orderBy('id', 'ASC')->get();
        }

        return response()->json($stages);
    }
}
