<?php

namespace App\Http\Resources\Api\Contacts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'VALUE' => $this->value,
            'BTX_ID' => $this->BTX_ID,
        ];
    }
}
