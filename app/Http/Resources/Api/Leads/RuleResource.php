<?php

namespace App\Http\Resources\Api\Leads;

use App\Http\Services\Services;
use App\Models\Field;
use App\Models\Rule;
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

        $rules = [];

        foreach (json_decode($this->rule) as $rule) {
            $rules[] = [
                'field_id' => (new FieldRuleResource(Field::find($rule->id))),
                'rule' => [
                    'rule_id' => $rule->rule,
                    'title' => Services::rules_fields($rule->rule),
                ],
                'text' => $rule->text,
            ];
        }

        $blocks = Rule::where('block', $this->block)->get();

        $fields = [];

        foreach ($blocks as $block) {
            $fld = Field::find($block->field_id);
            $fields[] = [
                'field_id' => $fld->id,
                'LIST_COLUMN_LABEL' => $fld->LIST_COLUMN_LABEL,
                'show' => $block->show,
            ];
        }

        return [
            'block_id' => $this->block,
            'block_type' => $this->rule_type,
            'block_title' => Services::rule_type($this->rule_type),
            'field_right' => $fields,
            'field_left' => $rules,
        ];
    }
}
