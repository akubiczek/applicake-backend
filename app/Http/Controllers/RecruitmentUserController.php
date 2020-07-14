<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecruitmentUserCreateRequest;
use App\Http\Resources\RecruitmentResource;
use App\Models\Recruitment;
use App\Services\TenantManager;
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

    public function list(Recruitment $recruitment)
    {
        return response()->json($recruitment->grantedUsers);
    }

    public function create(RecruitmentUserCreateRequest $request, Recruitment $recruitment)
    {
        //TODO logować kto kiedy dał komu dostęp bo relacje znikają z pivota
        $userId = $request->get('user_id');
        $recruitment->grantedUsers()->attach($userId, ['creator_id' => Auth::user()->id]);
        return response()->json($recruitment->grantedUsers);
    }

    public function delete(Recruitment $recruitment, $userId)
    {
        $recruitment->grantedUsers()->detach($userId);
        return response()->json($recruitment->grantedUsers);
    }
}
