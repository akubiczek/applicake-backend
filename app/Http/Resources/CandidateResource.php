<?php

namespace App\Http\Resources;

use App\Repositories\CandidatesRepository;
use App\Utils\PhoneFormatter;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
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
            'additional_info' => $this->additional_info,
            'otherApplications' => CandidatesRepository::getOtherApplications($this->resource),
            'source' => $this->source,
            'recruitment' => $this->recruitment,
            'stage' => $this->stage
        ];
    }
}
