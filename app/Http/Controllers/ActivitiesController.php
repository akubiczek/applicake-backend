<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivitiesController
{
    public function list(Request $request)
    {
        $result = Activity::where('candidate_id', $request->get('candidate_id'))->with('user')->get();

        return ActivityResource::collection($result);
    }
}
