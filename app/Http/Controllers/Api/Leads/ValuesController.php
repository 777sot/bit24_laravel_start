<?php

namespace App\Http\Controllers\Api\Leads;

use App\Http\Controllers\Controller;
use App\Http\Services\MyB24;
use App\Models\Field;
use App\Models\ListField;
use App\Models\Value;
use Illuminate\Http\Request;

class ValuesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 111;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->input();
        $member_id = $data['member_id'];
        $ENTITY_VALUE_ID = $data['ENTITY_VALUE_ID'];
        foreach ($data as $k => $value) {
            if ($k == 'member_id' || $k == 'ENTITY_VALUE_ID') continue;
            $field = Field::where('member_id', $member_id)->where('CRM_TYPE', 'CRM_LEAD')->find($k);

            if ($field) {
                if ($field->USER_TYPE_ID == 'string') {
                    $value = Value::updateOrCreate(
                        [
                            'field_id' => $field->id,
                            'ENTITY_VALUE_ID' => $ENTITY_VALUE_ID,
                        ], [
                        'field_id' => $field->id,
                        'VALUE' => $value,
                        'member_id' => $member_id,
                        'ENTITY_VALUE_ID' => $ENTITY_VALUE_ID,
                        'CRM_TYPE' => 'CRM_LEAD',
                        'BTX_ID' => $field->BTX_ID,
                    ]);
                } elseif ($field->USER_TYPE_ID == 'enumeration' && $field->MULTIPLE == false) {
                    $list = ListField::find($value);
                    if ($list) {
                        $value = Value::updateOrCreate(
                            [
                                'field_id' => $field->id,
                                'ENTITY_VALUE_ID' => $ENTITY_VALUE_ID,
                            ], [
                            'field_id' => $field->id,
                            'VALUE' => $list->BTX_ID,
                            'member_id' => $member_id,
                            'ENTITY_VALUE_ID' => $ENTITY_VALUE_ID,
                            'CRM_TYPE' => 'CRM_LEAD',
                            'BTX_ID' => $field->BTX_ID,
                        ]);
                    } elseif ($field->USER_TYPE_ID == 'enumeration' && $field->MULTIPLE == true) {

                    }

                }

            };


        }

        $new_values = Value::where('member_id', $member_id)->where('CRM_TYPE', 'CRM_LEAD')->where('ENTITY_VALUE_ID', $ENTITY_VALUE_ID)->get();
        $values_data = [];
        foreach ($new_values as $val) {
            $values_data["UF_CRM_" . $val->field->FIELD_NAME] = $val->VALUE;
//            if($val->field->USER_TYPE_ID == 'string'){
//                $values_data[ "UF_CRM_".$val->field->FIELD_NAME] = $val->VALUE;
//            }elseif ($val->field->USER_TYPE_ID == 'enumeration' && $val->field->MULTIPLE == false){
////                $list = ListField::find($val->VALUE);
//                $values_data[ "UF_CRM_".$val->field->FIELD_NAME] =  $val->VALUE;
//            }


        }

        $update = [];
        $update['ENTITY_VALUE_ID'] = $ENTITY_VALUE_ID;
        $update['member_id'] = $member_id;
        $update['values_data'] = $values_data;
//return $update;
        $res = MyB24::CallB24_upd_values('CRM_LEAD', $update);
        return $res;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
