<?php

namespace App\Http\Resources\Api\Fields;

use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DependencyResource extends JsonResource
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
            'list_field_id' => $this->list_field_id,
            'field_id' => $this->field_id,
            'list' => new ListResource($this->list_field),
            'field' => new FieldResource($this->field),
       ];
    }
}
