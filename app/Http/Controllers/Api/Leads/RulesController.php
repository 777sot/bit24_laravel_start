<?php

namespace App\Http\Controllers\Api\Leads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Leads\Rules\ShowRequest;
use App\Http\Requests\Api\Leads\Rules\StoreRequest;
use App\Http\Requests\Api\Leads\Rules\UpdateRequest;

use App\Http\Resources\Api\Leads\RuleResource;
use App\Http\Services\Services;
use App\Models\Field;
use App\Models\Rule;
use App\Models\Setting;
use Illuminate\Http\Request;

class RulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ShowRequest $request)
    {
        $data = $request->validated();

        $rules = Rule::where('CRM_TYPE', 'CRM_LEAD')->where('member_id', $data['member_id'])->get();

        return RuleResource::collection($rules);
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
        $member_id = $data['member_id'];

        $rules = json_decode($rules);

        if ($rule_type == 1 && count($rules) > 1) {
            return array('data' => [
                'status' => false,
                'messages' => '(rule_type == 1), rule must be 1 element in array',
            ]);
        }

        $fields = json_decode($fields);

        $results = array();

        $setting = Setting::where('member_id', $data['member_id'])->first();

        foreach ($fields as $field) {

            $field_val = Field::find($field->field_id);

            if (!$field_val) {
                return array('data' => [
                    'status' => false,
                    'messages' => "field_id = $field->field_id is not found",
                ]);
            }

            if ($field_val->member_id != $setting->member_id) {

                return array('data' => [
                    'status' => false,
                    'messages' => "member_id values are not valid",
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

                if ($field_val->member_id != $setting->member_id) {

                    return array('data' => [
                        'status' => false,
                        'messages' => "member_id values are not valid",
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
                'member_id' => $member_id,
            ], [
                'field_id' => $field->field_id,
                'CRM_TYPE' => "CRM_LEAD",
                'rule' => json_encode($rules),
                'rule_type' => $rule_type,
                'show' => $data['show'] ?? 0,
                'member_id' => $member_id,
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
//        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowRequest $request, string $id)
    {
        $data = $request->validated();

        $rule = Rule::find($id);

        if ($rule) {

            $setting = Setting::where('member_id', $data['member_id'])->first();

            if ($rule->member_id != $setting->member_id) {

                return array('data' => [
                    'status' => false,
                    'messages' => "member_id values are not valid",
                ]);
            }
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

            $setting = Setting::where('member_id', $data['member_id'])->first();

            if ($rule_data->member_id != $setting->member_id) {

                return array('data' => [
                    'status' => false,
                    'messages' => "member_id values are not valid",
                ]);
            }

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

                if ($field_val->member_id != $setting->member_id) {

                    return array('data' => [
                        'status' => false,
                        'messages' => "member_id values are not valid",
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

                    if ($field_val->member_id != $setting->member_id) {

                        return array('data' => [
                            'status' => false,
                            'messages' => "member_id values are not valid",
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
                    'rule' => json_encode($rules),
                    'rule_type' => $rule_type,
                    'show' => $data['show'] ?? 0,
                    'member_id' => $data['member_id'],
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
    public function destroy(ShowRequest $request, string $id)
    {
        $data = $request->validated();

        $rule = Rule::find($id);

        if ($rule) {

            $setting = Setting::where('member_id', $data['member_id'])->first();

            if ($rule->member_id != $setting->member_id) {

                return array('data' => [
                    'status' => false,
                    'messages' => "member_id values are not valid",
                ]);
            }

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

    /**
     * Remove the specified resource from storage.
     */
    public function check_rules(Request $request)
    {
        $data = $request->input();

        foreach ($data as $field_id => $value) {

            $field = Field::find($field_id);

            if (!$field) {
                return array('data' => [
                    'status' => false,
                    'messages' => "field_id = $field_id is not found",
                ]);
            }
        }

        return Services::checkLeadsFields($request);
    }
}
