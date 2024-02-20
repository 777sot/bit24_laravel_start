<?php

namespace App\Http\Controllers\Api\Leads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Leads\Rules\StoreRequest;
use App\Http\Requests\Api\Leads\Rules\UpdateRequest;
use App\Http\Resources\Api\Fields\FieldResource;
use App\Http\Resources\Api\Fields\RuleResource;
use App\Models\Field;
use App\Models\Rule;
use Illuminate\Http\Request;

class RulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RuleResource::collection(Rule::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $rules_fields = array(
            0 => 'РАВНО',
            1 => 'НЕ РАВНО',
            2 => 'НЕ ЗАПОЛНЕНО',
            3 => 'ЗАПОЛНЕНО',
            4 => 'СОДЕРЖИТ',
            5 => 'НЕ СОДЕРЖИТ',
        );


        $data = $request->validated();

        $fields = $data['fields'];
        $rules = $data['rule'];
        $rule_type = $data['rule_type'];

        $rules = json_decode($rules);

        if ($rule_type == 1 && count($rules) > 1) {
            return array('data' => [
                'status' => false,
                'messages' => '(rule_type == 1), rule must be 1 element in array',
            ]);
        }

        $fields = json_decode($fields);

        $results = array();

        foreach ($fields as $field) {

            $field_val = Field::find($field->field_id);

            if (!$field_val) {
                return array('data' => [
                    'status' => false,
                    'messages' => "field_id = $field->field_id is not found",
                ]);
            }


            foreach ($rules as $rule) {

                $field_val = Field::find($rule->id);

                if (!$field_val) {
                    return array('data' => [
                        'status' => false,
                        'messages' => "field_id = $rule->id is not found",
                    ]);
                }

                if (empty($rules_fields[$rule->rule])) {
                    return array('data' => [
                        'status' => false,
                        'messages' => "rule = $rule->rule is not found (rule must be: 0,1,2,3,4,5)",
                    ]);
                }

                if ($rule->id == $field->field_id) {
                    return array('data' => [
                        'status' => false,
                        'messages' => "field_id must not be equal to id",
                    ]);
                }

            }

            $results[] = Rule::firstOrCreate([
                'field_id' => $field->field_id,
                'rule' => json_encode($rules),
                'rule_type' => $rule_type,
            ], [
                'field_id' => $field->field_id,
                'CRM_TYPE' => "CRM_LEAD",
                'rule' => json_encode($rules),
                'rule_type' => $rule_type,
                'show' => $data['show'] ?? 0,
            ]);
        }
        return RuleResource::collection($results);


        //rule_type 1
//        $rule = [];
//        $rule['id'] = 1;
//        $rule['rule'] = 0;
//        $rule['text'] = "aaa";

        //TYPE_FIELD = 2
//        $rule = [];
//
//        $rule = [
//            [
//            'id' => 1,
//            'rule' => 0,
//            'text' => "zzz",
//                ],
//            [
//                'id' => 1,
//                'rule' => 0,
//                'text' => "fff",
//            ]
//        ];
//---------
        //TYPE_FIELD = 3
//        $rule = [];
//
//        $rule = [
//            [
//            'id' => 1,
//            'rule' => 0,
//            'text' => "abc",
//                ],
//            [
//                'id' => 1,
//                'rule' => 5,
//                'text' => "www",
//            ]
//        ];
//---------

//        $result = Rule::create([
//            'field_id' => 17,
//            'CRM_TYPE' => "CRM_LEAD",
//            'rule' => json_encode($rule),
//            'rule_type' => 3,
//            'show' => 1,
//        ]);
        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rule = Rule::find($id);

        if ($rule) {
            return new RuleResource($rule);
        } else {
            return array('data' => [
                'status' => false,
                'messages' => 'Rule is not found',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $rule_data = Rule::find($id);

        if ($rule_data) {

            $rules_fields = array(
                0 => 'РАВНО',
                1 => 'НЕ РАВНО',
                2 => 'НЕ ЗАПОЛНЕНО',
                3 => 'ЗАПОЛНЕНО',
                4 => 'СОДЕРЖИТ',
                5 => 'НЕ СОДЕРЖИТ',
            );

            $fields = $data['fields'];
            $rule_type = $data['rule_type'];
            $rules = $data['rule'];
            $rules = json_decode($rules);

            $fields = json_decode($fields);

            foreach ($fields as $field) {

                $field_val = Field::find($field->field_id);

                if (!$field_val) {
                    return array('data' => [
                        'status' => false,
                        'messages' => "field_id = $field->field_id is not found",
                    ]);
                }

                foreach ($rules as $rule) {

                    $field_val = Field::find($rule->id);

                    if (!$field_val) {
                        return array('data' => [
                            'status' => false,
                            'messages' => "field_id = $rule->id is not found",
                        ]);
                    }

                    if (empty($rules_fields[$rule->rule])) {
                        return array('data' => [
                            'status' => false,
                            'messages' => "rule = $rule->rule is not found (rule must be: 0,1,2,3,4,5)",
                        ]);
                    }

                    if ($rule->id == $field->field_id) {
                        return array('data' => [
                            'status' => false,
                            'messages' => "field_id must not be equal to id",
                        ]);
                    }

                }

                $rule_data->update([
                    'field_id' => $field->field_id,
                    'CRM_TYPE' => "CRM_LEAD",
                    'rule' => json_encode($rules),
                    'rule_type' => $rule_type,
                    'show' => $data['show'] ?? 0,
                ]);
                $rule_data->refresh();
            }

            return new RuleResource($rule_data);

        } else {
            return array('data' => [
                'status' => false,
                'messages' => 'Rule is not found',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rule = Rule::find($id);

        if ($rule) {

            $rule->delete();
            return array('data' => [
                'status' => true,
                'messages' => 'Rule is deleted',
            ]);
        } else {
            return array('data' => [
                'status' => false,
                'messages' => 'Rule is not found',
            ]);
        }
    }
}
