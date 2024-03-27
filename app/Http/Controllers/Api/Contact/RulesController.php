<?php

namespace App\Http\Controllers\Api\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Company\Rules\ShowRequest;
use App\Http\Requests\Api\Contacts\Rules\StoreRequest;
use App\Http\Requests\Api\Contacts\Rules\UpdateRequest;
use App\Http\Resources\Api\Contacts\RuleResource;
use App\Http\Services\Services;
use App\Models\Field;
use App\Models\Rule;
use App\Models\Setting;
use Illuminate\Http\Request;

class RulesController extends Controller
{
    /**
     * ВЫВОД ПРАВИЛ
     */
    public function index(ShowRequest $request)
    {
        $data = $request->validated();

        $rules = Rule::where('CRM_TYPE', 'CRM_CONTACT')
            ->where('member_id', $data['member_id'])
            ->orderBy('block', 'asc')
            ->get();

        $rules_arr = [];

        foreach ($rules as $rule) {
            if (empty($rules_arr[$rule->block])) {
                $rules_arr[$rule->block] = new RuleResource($rule);
            }
        }

        return [
            'data' => [...$rules_arr],
        ];
    }

    /**
     * ДОБАВЛЕНИЕ ПРАВИЛ
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

        $fields = $data['field_right'];
        $rules = $data['field_left'];

        $rule_type = $data['block_type'];

        $member_id = $data['member_id'];

        $rules = json_decode($rules);

        if ($rule_type == 1 && count($rules) > 1) {
            return array('data' => [
                'status' => false,
                'messages' => '(block_type == 1), rule must be 1 element in array',
            ]);
        }


        $fields = json_decode($fields);

        $results = array();

        $setting = Setting::where('member_id', $data['member_id'])->first();

        $block = 0;

        foreach ($fields as $field) {

            if (isset($field->show)) {
                $data['show'] = $field->show;
            }

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

            //ПРЕОБРАЗОВАНИЕ ЗАПРОСА
//            [ {"field_id": {"id": "2"}, "rule":{"rule_id":"3"}, "text": "abc"}]
//            В
//            [ { "id": "2", "rule": "3", "text": "abc" }]
            $upd_rules = [];
            foreach ($rules as $rule) {
                $field_rule_id = $rule->field_id->id;
                $rule_rule_id = $rule->rule->rule_id;
                $text = $rule->text;
                $upd_rules[] = (object)[
                    'id' => $field_rule_id,
                    'rule' => $rule_rule_id,
                    'text' => $text,
                ];
            }
//END
            foreach ($upd_rules as $rule) {

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

                $rul = Rule::latest()->first();

                if ($block == 0) {
                    if ($rul) {
                        $block = $rul->block + 1;
                    } else {
                        $block = 1;
                    }
                }
            }

            $results[] = Rule::firstOrCreate([
                'field_id' => $field->field_id,
                'rule' => json_encode($upd_rules),
                'rule_type' => $rule_type,
                'member_id' => $member_id,
            ], [
                'field_id' => $field->field_id,
                'CRM_TYPE' => "CRM_CONTACT",
                'rule' => json_encode($upd_rules),
                'rule_type' => $rule_type,
                'show' => $data['show'] ?? 0,
                'member_id' => $member_id,
                'block' => $block,
            ]);
        }
        return RuleResource::collection($results);
    }

    /**
     * ПОКАЗАТЬ ПРАВИЛО ПО ID
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
     * ОБНОВЛЕНИЕ ПРАВИЛ ПО ID
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

                if (isset($field->show)) {
                    $data['show'] = $field->show;
                }

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
     * УДАЛЕНИЕ ПРАВИЛА ПО ID
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
     * (УСТАРЕЛ)ПРОВЕРКА ПРАВИЛ ПО ID
     */
    public function check_rules(Request $request)
    {
        $data = $request->input();
        $data['CRM_TYPE'] = 'CRM_CONTACT';

        foreach ($data as $field_id => $value) {

if($field_id === 'CRM_TYPE' || $field_id === 'member_id') continue;

            $field = Field::find($field_id);

            if (!$field) {
                return array('data' => [
                    'status' => false,
                    'messages' => "field_id = $field_id is not found",
                ]);
            }
        }

        return Services::checkLeadsFields($data);
    }

    /**
     * ИЗМЕНЕНИЕ ИНДЕКСОВ
     */
    public function indexblock(ShowRequest $request, string $id)
    {
        $data = $request->validated();

        $rules = Rule::where('CRM_TYPE', 'CRM_CONTACT')
            ->where('member_id', $data['member_id'])
            ->where('block', $id)
            ->get();

        if (count($rules) > 0) {

            $rules_arr = [];

            foreach ($rules as $rule) {
                if (empty($rules_arr[$rule->block])) {
                    $rules_arr[$rule->block] = new RuleResource($rule);
                }
            }

            return [
                'data' => [...$rules_arr],
            ];

        } else {
            return array('data' => [
                'status' => false,
                'messages' => 'RuleBLOCK is not found',
            ]);
        }
    }

    /**
     * ОБНОВЛЕНИЕ БЛОКОВ ПРАВИЛ
     */
    public function updateblock(UpdateRequest $request, string $id)
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

        $rules_block = Rule::where('CRM_TYPE', 'CRM_CONTACT')
            ->where('member_id', $data['member_id'])
            ->where('block', $id)
            ->get();

//        $fields = $data['fields'];
        $fields = $data['field_right'];
        $rules = $data['field_left'];

        $fields = json_decode($fields);

        if (count($rules_block) == 0) {
            return array('data' => [
                'status' => false,
                'messages' => 'RuleBLOCK is not found',
            ]);
        }

        foreach ($rules_block as $r_block) {
            $rule_type = $r_block->rule_type;
            $check = 0;
            foreach ($fields as $field) {
                if ($field->field_id == $r_block->field_id) {
                    $check = 1;
                }
            }
            if ($check == 0) {
                $r_block->delete();
            }
        }

//        $rules = $data['rule'];

        $member_id = $data['member_id'];

        $rules = json_decode($rules);

        if ($rule_type == 1 && count($rules) > 1) {
            return array('data' => [
                'status' => false,
                'messages' => '(rule_type == 1), rule must be 1 element in array',
            ]);
        }

        $results = array();

        $setting = Setting::where('member_id', $data['member_id'])->first();

        foreach ($fields as $field) {

            if (isset($field->show)) {
                $data['show'] = $field->show;
            }

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

            //ПРЕОБРАЗОВАНИЕ ЗАПРОСА
//            [ {"field_id": {"id": "2"}, "rule":{"rule_id":"3"}, "text": "abc"}]
//            В
//            [ { "id": "2", "rule": "3", "text": "abc" }]
            $upd_rules = [];
            foreach ($rules as $rule) {
                $field_rule_id = $rule->field_id->id;
                $rule_rule_id = $rule->rule->rule_id;
                $text = $rule->text;
                $upd_rules[] = (object)[
                    'id' => $field_rule_id,
                    'rule' => $rule_rule_id,
                    'text' => $text,
                ];
            }
//END

            foreach ($upd_rules as $rule) {

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

            $results[] = Rule::updateOrCreate([
                'field_id' => $field->field_id,
                'member_id' => $member_id,
                'block' => $id,
            ], [
                'field_id' => $field->field_id,
                'CRM_TYPE' => "CRM_CONTACT",
                'rule' => json_encode($upd_rules),
                'rule_type' => $rule_type,
                'show' => $data['show'] ?? 0,
                'member_id' => $member_id,
                'block' => $id,
            ]);
        }

        $rules = Rule::where('CRM_TYPE', 'CRM_CONTACT')
            ->where('member_id', $data['member_id'])
            ->where('block', $id)
            ->get();

        $rules_arr = [];

        foreach ($rules as $rule) {
            if (empty($rules_arr[$rule->block])) {
                $rules_arr[$rule->block] = new RuleResource($rule);
            }
        }

        return [
            'data' => [...$rules_arr],
        ];
    }

    /**
     * УДАЛЕНИЕ БЛОКОВ ПРАВИЛ
     */
    public function destroyblock(ShowRequest $request, string $id)
    {
        $data = $request->validated();

        $rules = Rule::where('CRM_TYPE', 'CRM_CONTACT')
            ->where('member_id', $data['member_id'])
            ->where('block', $id)
            ->get();

        if (count($rules) > 0) {

            foreach ($rules as $rule) {

                $setting = Setting::where('member_id', $data['member_id'])->first();

                if ($rule->member_id != $setting->member_id) {

                    return array('data' => [
                        'status' => false,
                        'messages' => "member_id values are not valid",
                    ]);
                }

                $rule->delete();
            }
            return array('data' => [
                'status' => true,
                'messages' => 'RuleBlock is deleted',
            ]);
        } else {
            return array('data' => [
                'status' => false,
                'messages' => 'RuleBLOCK is not found',
            ]);
        }
    }

}
