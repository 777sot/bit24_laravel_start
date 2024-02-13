<?php

namespace App\Http\Services;

use App\Models\Rule;

class ApiServices
{

    static public function ruleAdd($request, $type){

        if($type == 1){

            $field_id = $request->input('field_id');
            $rule_type = $request->input('rule_type');
            $show = $request->input('show');

            if($rule_type === 1){
                $rule = [];
                $rule['id'] = 1;
                $rule['rule'] = 0;
                $rule['text'] = $request->input('text');

                $field = Rule::create([
                    'field_id' => $field_id,
                    'rule' => json_encode($rule),
                    'rule_type' => $rule_type,
                    'show' => $show,
                ]);
            }
        }elseif ($type == 2){
            $data_all = [];
            return json_encode($request->input());
        }


        return $field;
    }
}
