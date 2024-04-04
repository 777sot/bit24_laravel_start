<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Company\Fields\ShowRequest;
use App\Http\Requests\Api\Company\Fields\StoreRequest;
use App\Http\Requests\Api\Company\Fields\UpdateRequest;
use App\Http\Resources\Api\Company\FieldResource;
use App\Http\Services\MyB24;
use App\Models\Field;
use App\Models\ListField;
use App\Models\Rule;
use App\Models\Setting;
use Illuminate\Http\Request;

class FieldsController extends Controller
{
    /**
     * ВЫВОД СПИСКА ПОЛЕЙ
     */
    public function index(ShowRequest $request)
    {

        $data = $request->validated();

        $fields = Field::where('CRM_TYPE', 'CRM_COMPANY')->where('member_id', $data['member_id'])->get();

        return FieldResource::collection($fields);
    }

    /**
     * ДОБАВЛЕНИЕ ПОЛЕЙ
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $field_name = mb_strtoupper($data['USER_TYPE_ID']);

        $field = Field::where('FIELD_NAME', 'LIKE', "%{$field_name}%")
            ->orderBy('id', 'desc')
            ->first();

        if (!$field) {
            $data['FIELD_NAME'] = $field_name . "_1";
        } else {
            $field = Field::where('FIELD_NAME', 'LIKE', "%{$field_name}%")
                ->orderBy('id', 'desc')
                ->first();

            $num = explode('_', $field->FIELD_NAME);
            $data['FIELD_NAME'] = $field_name . "_" . ++$num[1];
        }

        $data['CRM_TYPE'] = "CRM_COMPANY";

        $data['EDIT_FORM_LABEL'] = $data['LIST_COLUMN_LABEL'];
        $data['XML_ID'] = $data['FIELD_NAME'];
        $data['MULTIPLE'] = $data['MULTIPLE'] ?? 0;

        $field = Field::firstOrCreate([
            'LIST_COLUMN_LABEL' => $data['LIST_COLUMN_LABEL'],
            'CRM_TYPE' => $data['CRM_TYPE'],
            'member_id' => $data['member_id']
        ], $data);

        if ($data['USER_TYPE_ID'] == "enumeration" && !empty($data['LIST'])) {

            $lists = json_decode($data['LIST']);

            foreach ($lists as $list) {
                if (!isset($list->VALUE)) {
                    return array('data' =>
                        ['status' => false],
                        ['message' => "LIST VALUES IS EMPTY"],
                    );
                };
                ListField::firstOrCreate([
                    'field_id' => $field->id,
                    'value' => $list->VALUE,
                ], [
                    'field_id' => $field->id,
                    'CRM_TYPE' => $data['CRM_TYPE'],
                    'value' => $list->VALUE,
                ]);
            }
        }

        if ($field) {
            //ДОБАВЛЕНИЕ ПОЛЯ В БИТРИКС
            //  enumeration
            if ($field->USER_TYPE_ID == 'enumeration') {
                //ПРОВЕРЯЕМ ПОЛЕ В БИТРИКС
                if (empty($field->BTX_ID)) {
                    $add_field_list = MyB24::CallB24_field_enumeration_add_new("CRM_COMPANY", $data);
                    if (isset($add_field_list['result'])) {
                        $btx_id = $add_field_list['result'];
                        $field->BTX_ID = $btx_id;
                        $field->save();
                        //ДОБАВЛЕНИЕ LIST BTX_ID
                        $usr_field_list = MyB24::CallB24_field_list_new("CRM_COMPANY", $field->member_id, $field->BTX_ID);
                        foreach ($usr_field_list['result']['LIST'] as $btx_list) {
                            $list_fnd = ListField::where('field_id', $field->id)->where('value', $btx_list['VALUE'])->first();
                            $list_fnd->BTX_ID = $btx_list['ID'];
                            $list_fnd->save();
                        }
                    }
                }

            } elseif ($field->USER_TYPE_ID == 'string') {
                //ПРОВЕРЯЕМ ПОЛЕ В БИТРИКС
                if (empty($field->BTX_ID)) {
                    // string
                    $add_field_text = MyB24::CallB24_field_text_add_new("CRM_COMPANY", $data);
                    $btx_id = $add_field_text['result'];
                    $field->BTX_ID = $btx_id;
                    $field->save();
                }
            }

            return new FieldResource($field);
        } else {
            return array('data' => ['status' => false]);
        }
    }

    /**
     * ВЫВОД ПОЛЯ ПО ID
     */
    public function show(ShowRequest $request, string $id)
    {
        $data = $request->validated();

        $field = Field::find($id);

        if ($field) {

            $setting = Setting::where('member_id', $data['member_id'])->first();

            if ($field->member_id != $setting->member_id) {
                return array('data' => [
                    'status' => false,
                    'messages' => "member_id values are not valid",
                ]);
            }


            return new FieldResource($field);
        } else {
            return array('data' => [
                'status' => false,
                'messages' => 'Field is not found',
            ]);
        }
    }

    /**
     * ОБНОВЛЕНИЕ ПОЛЯ
     */
    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $field = Field::find($id);

        if ($field) {

            if (!empty($data['member_id'])) {

                $setting = Setting::where('member_id', $data['member_id'])->first();

                if ($field->member_id != $setting->member_id) {

                    return array('data' => [
                        'status' => false,
                        'messages' => "member_id values are not valid",
                    ]);
                }
            }

            $data['EDIT_FORM_LABEL'] = $data['LIST_COLUMN_LABEL'];
            $field->update($data);
            $field->refresh();

            //ОБНОВЛЕНИЕ ПОЛЯ В БИТРИКС
            //  list
            if ($field->USER_TYPE_ID == 'enumeration' && !empty($field->BTX_ID)) {
                $data['FIELD_NAME'] = $field->FIELD_NAME;
                $data['XML_ID'] = $field->XML_ID;
                $data['USER_TYPE_ID'] = $field->USER_TYPE_ID;
                $data['CRM_TYPE'] = $field->CRM_TYPE;
                $data['MULTIPLE'] = (!empty($data['MULTIPLE'])) ? $data['MULTIPLE'] : $field->MULTIPLE;
                $add_field_list = MyB24::CallB24_field_enumeration_upd_new("CRM_COMPANY", $data, $field->BTX_ID);
                if (isset($add_field_list['result'])) {
                    $btx_id = $add_field_list['result'];
                    $field->BTX_ID = $btx_id;
                }
                $field->save();

            }
            //  list
            if ($field->USER_TYPE_ID == 'string' && !empty($field->BTX_ID)) {
                $data['BTX_ID'] = $field->BTX_ID;
                $upd_field_text = MyB24::CallB24_field_text_upd_new("CRM_COMPANY", $data);
            }
            ///---

            if (!empty($data['LIST'])) {

                $field->lists()->delete();
                $lists = json_decode($data['LIST']);
                foreach ($lists as $list) {
                    if (!isset($list->VALUE)) {
                        return array('data' =>
                            ['status' => false],
                            ['message' => "LIST VALUES IS EMPTY"],
                        );
                    };
                    ListField::firstOrCreate([
                        'field_id' => $field->id,
                        'value' => $list->VALUE,
                    ], [
                        'field_id' => $field->id,
                        'CRM_TYPE' => $field->CRM_TYPE,
                        'value' => $list->VALUE,
                    ]);
                }

                //ДОБАВЛЕНИЕ LIST BTX_ID
                $usr_field_list = MyB24::CallB24_field_list_new("CRM_COMPANY", $field->member_id, $field->BTX_ID);
                foreach ($usr_field_list['result']['LIST'] as $btx_list) {
                    $list_fnd = ListField::where('field_id', $field->id)->where('value', $btx_list['VALUE'])->first();
                    $list_fnd->BTX_ID = $btx_list['ID'];
                    $list_fnd->save();
                }
            }

            return new FieldResource($field);
        } else {
            return array('data' => [
                'status' => false,
                'messages' => 'Field is not found',
            ]);
        }
    }

    /**
     * УДАЛЕНИЕ ПОЛЯ
     */
    public function destroy(ShowRequest $request, string $id)
    {
        $data = $request->validated();

        $field = Field::find($id);

        if ($field) {

            $setting = Setting::where('member_id', $data['member_id'])->first();

            if ($field->member_id != $setting->member_id) {

                return array('data' => [
                    'status' => false,
                    'messages' => "member_id values are not valid",
                ]);
            }

            $rules = Rule::all();

            foreach ($rules as $rule) {
                if ($rule->field_id == $id) {
                    $rule->delete();
                    continue;
                }
                $rule_arr = json_decode($rule->rule);
                $new_rule = array();
                foreach ($rule_arr as $value) {
                    if ($value->id == $id) {
                        continue;
                    } else {
                        $new_rule[] = $value;
                    }
                }
                $rule->update([
                    'rule' => json_encode($new_rule)
                ]);
            }

            if (!empty($field->BTX_ID)) {
                //УДАЛЕНИЕ ПОЛЯ В БИТРИКС
                $del_field = MyB24::CallB24_field_del_new("CRM_COMPANY", $field->member_id, $field->BTX_ID);
                ///---
            }

            $field->lists()->delete();
            $field->values()->delete();
            $field->delete();


            return array('data' => [
                'status' => true,
                'messages' => 'Field is deleted',
            ]);
        } else {
            return array('data' => [
                'status' => false,
                'messages' => 'Field is not found',
            ]);
        }
    }

    /**
     * ОБНОВЛЕНИЕ ИНДЕКСОВ ПОЛЕЙ
     */
    public function update_index(Request $request)
    {
        $data = $request->input();

        if (empty($data['index'])) {

            return array('data' => [
                'status' => false,
                'messages' => "index is empty",
            ]);
        }

        $indexs = json_decode($data['index']);

        $count_fields = Field::where('CRM_TYPE', "CRM_COMPANY")->count();

        if ($count_fields != count($indexs)) {
            return array('data' => [
                'status' => false,
                'messages' => "The number of fields is not equal to the number of indexes",
            ]);
        }

        foreach ($indexs as $index) {

            $field = Field::find($index->field_id);

            if (!$field) {
                return array('data' => [
                    'status' => false,
                    'messages' => "Field ID = $index->field_id is not found",
                ]);
            }

            $field->update([
                'index' => $index->index
            ]);
        }

        $fields = Field::where('CRM_TYPE', "CRM_DEAL")->get();

        return FieldResource::collection($fields);
    }
}
