<?php

namespace App\Http\Resources;

use App\Models\Candidate;
use App\Models\Stage;
use App\Services\TenantManager;
use Illuminate\Http\Resources\Json\JsonResource;

class RecruitmentResource extends JsonResource
{
    /**
     * @var TenantManager
     */
    protected static $tenantManager;

    public static function setTenantManager($tenantManager)
    {
        self::$tenantManager = $tenantManager;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $array = parent::toArray($request);

        unset($array['deleted_at']);
        unset($array['is_draft']);

        //TODO ten kawałek do optymalizacji wydajnościowej
        //TODO na razie nie obsługujemy stages per recruitment
        //$stages = Stage::where('recruitment_id', $recruitment->id)->get();
        $stages = Stage::select(['id', 'name'])->get();

        foreach ($stages as $stage) {
            $count = Candidate::where('recruitment_id', $array['id'])->where('stage_id', $stage->id)->count();
            $stage->count = $count;
            $array['stages'][] = $stage;
        }

        foreach ($array['sources'] as $key => $source) {

            unset($array['sources'][$key]['created_at']);
            unset($array['sources'][$key]['updated_at']);
            unset($array['sources'][$key]['deleted_at']);
            unset($array['sources'][$key]['recruitment_id']);
            unset($array['sources'][$key]['key']);
            unset($array['sources'][$key]['url_path']);

            //TODO: zduplikowany kod z SourceResource
            $array['sources'][$key]['url'] = config('app.apply_url') . '/' . static::$tenantManager->getTenant()->subdomain . '/' . $source['key']
                . '-' . preg_replace("/[^A-Za-z0-9\-]/", '', str_replace(' ', '-', $array['job_title']));
        }

        return $array;
    }
}
