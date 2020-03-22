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
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => PhoneFormatter::format($this->phone_number),
            'future_agreement' => $this->future_agreement,
            'path_to_cv' => $this->path_to_cv,
            'source_id' => $this->source_id,
            'recruitment_id' => $this->recruitment_id,
            'source_recruitment_id' => $this->source_recruitment_id,
            'stage_id' => $this->stage_id,
            'rate' => $this->rate,
            'recruitment' => $this->recruitment,
        ];
    }
}
