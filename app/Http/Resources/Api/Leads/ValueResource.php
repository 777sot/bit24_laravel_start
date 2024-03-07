<?php

namespace App\Http\Resources\Api\Leads;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'field_id' => $this->field_id,
            'VALUE' => $this->VALUE,
        ];
    }
}
