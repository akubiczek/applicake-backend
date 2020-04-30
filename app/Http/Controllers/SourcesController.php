<?php

namespace App\Http\Controllers;

use App\Http\Requests\SourceCreateRequest;
use App\Http\Resources\SourceResource;
use App\Models\Source;
use App\Services\TenantManager;
use App\Utils\SourceCreator;
use Illuminate\Http\Request;

class SourcesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param TenantManager $tenantManager
     * @return void
     */
    public function __construct(TenantManager $tenantManager)
    {
        SourceResource::setTenantManager($tenantManager); //workaround - not the best but it works well
    }

    public function list(Request $request)
    {
        $recruitmentId = $request->get('recruitment_id');

        if ($recruitmentId) {
            $sources = Source::where('recruitment_id', $recruitmentId)->orderBy('created_at', 'DESC')->get();
        } else {
            $sources = Source::orderBy('created_at', 'DESC')->get();
        }

        return SourceResource::collection($sources);
    }

    public function create(SourceCreateRequest $request)
    {
        $source = SourceCreator::create($request->validated());
        return new SourceResource($source);
    }

    public function delete($sourceId)
    {
        Source::find($sourceId)->delete();
        return response()->json(null, 200);
    }
}
