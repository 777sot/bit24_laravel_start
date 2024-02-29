<?php

namespace App\Http\Resources\Api\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
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
            'CRM_TYPE' => $this->CRM_TYPE,
            'LIST_COLUMN_LABEL' => $this->LIST_COLUMN_LABEL,
            'USER_TYPE_ID' => $this->USER_TYPE_ID,
            'MULTIPLE' => $this->MULTIPLE,
            'index' => $this->index,
            'member_id' => $this->member_id,
            "LIST" => ($this->USER_TYPE_ID === "enumeration") ? ListResource::collection($this->lists) : 0
        ];
    }
}
