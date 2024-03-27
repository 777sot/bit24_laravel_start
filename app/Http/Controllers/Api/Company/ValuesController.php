<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Company\FieldResource;
use App\Http\Services\MyB24;
use App\Http\Services\Services;
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
        //
    }

    /**
     * ДОБАВЛЕНИЕ/ОБНОВЛЕНИЕ ЗНАЧЕНИЙ В КАРТОЧКЕ СУЩНОСТИ
     */
    public function store(Request $request)
    {
        $data = $request->input();
        $member_id = $data['member_id'];
        $ENTITY_VALUE_ID = $data['ENTITY_VALUE_ID'];
        foreach ($data as $k => $value) {
            if ($k == 'member_id' || $k == 'ENTITY_VALUE_ID') continue;
            $field = Field::where('member_id', $member_id)->where('CRM_TYPE', 'CRM_COMPANY')->find($k);
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
                        'CRM_TYPE' => 'CRM_COMPANY',
                        'BTX_ID' => $field->BTX_ID,
                    ]);
                } elseif ($field->USER_TYPE_ID == 'enumeration' && $field->MULTIPLE == 0) {
                    $list = ListField::where('BTX_ID', $value)->first();
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
                            'CRM_TYPE' => 'CRM_COMPANY',
                            'BTX_ID' => $field->BTX_ID,
                        ]);
                    }

                } elseif ($field->USER_TYPE_ID == 'enumeration' && $field->MULTIPLE == 1) {
                    $multi = [];
                    foreach (json_decode($value) as $val) {
                        $list = ListField::where('BTX_ID', $val)->first();
                        if ($list) {
                            $multi[] = $list->BTX_ID;
                        }
                    }
                    $value = Value::updateOrCreate(
                        [
                            'field_id' => $field->id,
                            'ENTITY_VALUE_ID' => $ENTITY_VALUE_ID,
                        ], [
                        'field_id' => $field->id,
                        'VALUE' => json_encode($multi),
                        'member_id' => $member_id,
                        'ENTITY_VALUE_ID' => $ENTITY_VALUE_ID,
                        'CRM_TYPE' => 'CRM_COMPANY',
                        'BTX_ID' => $field->BTX_ID,
                    ]);
                }
            };
        }
        $new_values = Value::where('member_id', $member_id)->where('CRM_TYPE', 'CRM_COMPANY')->where('ENTITY_VALUE_ID', $ENTITY_VALUE_ID)->get();
        $values_data = [];
        $results = [];

        foreach ($new_values as $value) {
            $results[$value->field_id] = $value->VALUE;
        }
        $results['CRM_TYPE'] = 'CRM_COMPANY';
        $results['member_id'] = $member_id;

        $checks = Services::checkLeadsFields($results);
        $check_res = [];
        foreach ($checks as $check) {
            foreach ($check as $k => $ch) {
                $check_res[$k] = $ch;
            }
        }
        $response_data = [];
        foreach ($new_values as $val) {
            if (array_key_exists($val->field_id, $check_res)) {
                $response_data[] = [
                    'field_id' => new FieldResource($field),
                    'show' => $check_res[$val->field_id]['show'],
                    'VALUE' => $val->VALUE,
                ];
            } else {
                $response_data[] = [
                    'field_id' => new FieldResource($field),
                    'show' => 1,
                    'VALUE' => $val->VALUE,
                ];
            }
            if ($val->field->MULTIPLE == 1) {
                $values_data["UF_CRM_" . $val->field->FIELD_NAME] = json_decode($val->VALUE);
                continue;
            };
            $values_data["UF_CRM_" . $val->field->FIELD_NAME] = $val->VALUE;
        }
        $update = [];
        $update['ENTITY_VALUE_ID'] = $ENTITY_VALUE_ID;
        $update['member_id'] = $member_id;
        $update['values_data'] = $values_data;
        $res = MyB24::CallB24_upd_values('CRM_COMPANY', $update);
        return ['data' => $response_data];
    }

    /**
     * ВЫВОДИМ ПОЛЯ И ЗНАЧЕНИЯ В КАРТОЧКЕ СУЩНОСТИ
     */
    public function show(Request $request, string $id)
    {
        $data = $request->input();

        $values = Value::where("CRM_TYPE", "CRM_COMPANY")
            ->where("member_id", $data['member_id'])
            ->where("ENTITY_VALUE_ID", $id)
            ->get();

        $results = [];

        foreach ($values as $value) {
            $results[$value->field_id] = $value->VALUE;
        }

        $results['CRM_TYPE'] = 'CRM_COMPANY';
        $results['member_id'] = $data['member_id'];

        $checks = Services::checkLeadsFields($results);
        $check_res = [];
        foreach ($checks as $check) {
            foreach ($check as $k => $ch) {
                $check_res[$k] = $ch;
            }
        }

        $response_data = [];

        $fields = Field::where("CRM_TYPE", "CRM_COMPANY")
            ->where("member_id", $data['member_id'])
            ->get();

        foreach ($fields as $field) {

            $val = Value::where("CRM_TYPE", "CRM_COMPANY")
                ->where("member_id", $data['member_id'])
                ->where("ENTITY_VALUE_ID", $id)
                ->where("field_id", $field->id)
                ->first();

            if (array_key_exists($field->id, $check_res)) {
                $response_data[] = [
                    'field_id' => new FieldResource($field),
                    'show' => $check_res[$field->id]['show'],
                    'VALUE' => (isset($val->VALUE)) ? $val->VALUE : "",
                ];

            } else {
                $response_data[] = [
                    'field_id' => new FieldResource($field),
                    'show' => 1,
                    'VALUE' => (isset($val->VALUE)) ? $val->VALUE : "",
                ];
            }
        }

        return ['data' => $response_data];
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
    /**
     * РАБОТА С ПРЕДПРОСМОТРОМ
     */
    public function store_view(Request $request)
    {
        $data = $request->input();
        $member_id = $data['member_id'];
        $ENTITY_VALUE_ID = 0;
        foreach ($data as $k => $value) {
            if ($k == 'member_id' || $k == 'ENTITY_VALUE_ID') continue;
            $field = Field::where('member_id', $member_id)->where('CRM_TYPE', 'CRM_COMPANY')->find($k);
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
                        'CRM_TYPE' => 'CRM_COMPANY',
                        'BTX_ID' => $field->BTX_ID,
                    ]);
                } elseif ($field->USER_TYPE_ID == 'enumeration' && $field->MULTIPLE == 0) {
                    $list = ListField::where('BTX_ID', $value)->first();
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
                            'CRM_TYPE' => 'CRM_COMPANY',
                            'BTX_ID' => $field->BTX_ID,
                        ]);
                    }

                } elseif ($field->USER_TYPE_ID == 'enumeration' && $field->MULTIPLE == 1) {
                    $multi = [];
                    foreach (json_decode($value) as $val) {
                        $list = ListField::where('BTX_ID', $val)->first();
                        if ($list) {
                            $multi[] = $list->BTX_ID;
                        }
                    }
                    $value = Value::updateOrCreate(
                        [
                            'field_id' => $field->id,
                            'ENTITY_VALUE_ID' => $ENTITY_VALUE_ID,
                        ], [
                        'field_id' => $field->id,
                        'VALUE' => json_encode($multi),
                        'member_id' => $member_id,
                        'ENTITY_VALUE_ID' => $ENTITY_VALUE_ID,
                        'CRM_TYPE' => 'CRM_COMPANY',
                        'BTX_ID' => $field->BTX_ID,
                    ]);
                }

            };
        }
        $new_values = Value::where('member_id', $member_id)
            ->where('CRM_TYPE', 'CRM_COMPANY')
            ->where('ENTITY_VALUE_ID', $ENTITY_VALUE_ID)->get();
        $values_data = [];
        $results = [];

        foreach ($new_values as $value) {
            $results[$value->field_id] = $value->VALUE;
        }
        $results['CRM_TYPE'] = 'CRM_COMPANY';
        $results['member_id'] = $member_id;

        $checks = Services::checkLeadsFields($results);
        $check_res = [];
        foreach ($checks as $check) {
            foreach ($check as $k => $ch) {
                $check_res[$k] = $ch;
            }
        }
        $response_data = [];

        $fields = Field::where("CRM_TYPE", "CRM_COMPANY")
            ->where("member_id", $data['member_id'])
            ->get();

        foreach ($fields as $field) {

            $val = Value::where("CRM_TYPE", "CRM_COMPANY")
                ->where("member_id", $data['member_id'])
                ->where("ENTITY_VALUE_ID", $ENTITY_VALUE_ID)
                ->where("field_id", $field->id)
                ->first();

            if (array_key_exists($field->id, $check_res)) {
                $response_data[] = [
                    'field_id' => new FieldResource($field),
                    'show' => $check_res[$field->id]['show'],
                    'VALUE' => (isset($val->VALUE)) ? $val->VALUE : "",
                ];

            } else {
                $response_data[] = [
                    'field_id' => new FieldResource($field),
                    'show' => 1,
                    'VALUE' => (isset($val->VALUE)) ? $val->VALUE : "",
                ];
            }
        }

        return ['data' => $response_data];
    }
}
