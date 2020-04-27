<?php

namespace App\Http\Resources;

use App\Services\TenantManager;
use Illuminate\Http\Resources\Json\JsonResource;

class SourceResource extends JsonResource
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
        $array['url'] = config('app.apply_url') . '/' . static::$tenantManager->getTenant()->subdomain . '/' . $array['key']
            . '-' . preg_replace("/[^A-Za-z0-9\-]/", '', str_replace(' ', '-', $this->recruitment->job_title));

        return $array;
    }
}
