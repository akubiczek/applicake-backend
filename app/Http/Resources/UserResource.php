<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                 => $this->id,
            'created_at'         => $this->created_at,
            'name'               => $this->name,
            'email'              => $this->email,
            'pending_invitation' => $this->pending_invitation,
            'roles'              => $this->roles->pluck('name'),
        ];
    }
}
