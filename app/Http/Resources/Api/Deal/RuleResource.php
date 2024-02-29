<?php

namespace App\Http\Resources\Api\Deal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => true,
            'id' => $this->id,
            'field_id' => $this->field_id,
            'rule' => json_decode($this->rule),
        ];
    }
}
