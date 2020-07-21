<?php

namespace App\Http\Resources;

use App\Models\Stage;
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
        $valueText = $this->new_value;
        if ($this->type === Stage::class) {
            $valueText = Stage::find($this->new_value)->name;
        }

        return [
            'created_at' => $this->created_at,
            'type' => $this->type,
            'prev_value' => $this->prev_value,
            'new_value' => $this->new_value,
            'new_value_text' => $valueText,
            'user' => [
                'name' => $this->user->name,
            ]
        ];
    }
}
