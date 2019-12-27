<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecruitmentUpdateRequest;
use App\Recruitment;
use App\Source;
use Illuminate\Http\Request;

class RecruitmentsController extends Controller
{
    public function list()
    {
        $recruitments = Recruitment::withCount(['candidates', 'candidates as new_candidates_count' => function ($query) {
                            $query->where('stage_id', 1);
                        }])->get();
        return response()->json($recruitments);
    }

    public function get($recruitmentId)
    {
        $recruitment = Recruitment::find($recruitmentId);
        return response()->json($recruitment);
    }
}
