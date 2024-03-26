<?php

namespace App\Http\Resources\Api\Contacts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ValuesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return $request->input();
        return [
            'status' => true,
            'id' => $this->id,
            'CRM_TYPE' => $this->CRM_TYPE,
            'FIELD_NAME' => $this->FIELD_NAME,
            'LIST_COLUMN_LABEL' => $this->LIST_COLUMN_LABEL,
            'USER_TYPE_ID' => $this->USER_TYPE_ID,
            'MULTIPLE' => $this->MULTIPLE,
            'index' => $this->index,
            'member_id' => $this->member_id,
            'BTX_ID' => $this->BTX_ID,
            "LIST" => ($this->USER_TYPE_ID === "enumeration") ? ListResource::collection($this->lists) : 0,
            "show" => $this->show,
            "VALUE" => $$this->VALUE,
        ];
    }
}
