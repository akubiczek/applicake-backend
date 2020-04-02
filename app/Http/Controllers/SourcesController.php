<?php

namespace App\Http\Controllers;

use App\Http\Requests\SourceCreateRequest;
use App\Http\Resources\SourceResource;
use App\Utils\SourceCreator;

class SourcesController extends Controller
{
    public function create(SourceCreateRequest $request)
    {
        $source = SourceCreator::create($request->validated());
        return new SourceResource($source);
    }
}
