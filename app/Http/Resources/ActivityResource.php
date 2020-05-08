<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'created_at' => $this->created_at,
            'type' => $this->type,
            'prev_value' => $this->prev_value,
            'new_value' => $this->new_value,
            'user' => [
                'name' => $this->user->name,
            ]
        ];
    }
}
