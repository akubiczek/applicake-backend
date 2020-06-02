<?php

namespace App\Http\Resources;

use App\Utils\PhoneFormatter;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TruncatedCandidateResource
 * This is a lite version of CandidateResource using when returning collection (to speed things up).
 * @package App\Http\Resources
 */
class TruncatedCandidateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array = [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => PhoneFormatter::format($this->phone_number),
            'recruitment_id' => $this->recruitment_id,
            'stage_id' => $this->stage_id,
            'seen_at' => $this->seen_at,
            'rate' => $this->rate,
            'recruitment' => $this->recruitment,
            'stage' => $this->stage,
        ];

        unset($array['stage']['created_at']);
        unset($array['stage']['updated_at']);
        unset($array['stage']['recruitment_id']);
        unset($array['recruitment']['created_at']);
        unset($array['recruitment']['updated_at']);
        unset($array['recruitment']['deleted_at']);
        unset($array['recruitment']['is_draft']);
        unset($array['recruitment']['notification_email']);

        return $array;
    }
}
