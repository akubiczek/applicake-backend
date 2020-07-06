<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecruitmentCloseRequest;
use App\Http\Requests\RecruitmentCreateRequest;
use App\Http\Requests\RecruitmentUpdateRequest;
use App\Http\Resources\RecruitmentResource;
use App\Models\Recruitment;
use App\Services\TenantManager;
use App\Utils\Recruitments\RecruitmentCreator;
use App\Utils\Recruitments\RecruitmentReplicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecruitmentUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param TenantManager $tenantManager
     * @return void
     */
    public function __construct(TenantManager $tenantManager)
    {
        RecruitmentResource::setTenantManager($tenantManager); //workaround - not the best but it works well
    }

    public function create(Request $request)
    {
    }

    public function delete(Request $request)
    {
    }
}
