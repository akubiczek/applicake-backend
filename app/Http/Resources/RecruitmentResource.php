<?php

namespace App\Http\Resources;

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
