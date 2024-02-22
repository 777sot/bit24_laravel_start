<?php

namespace App\Http\Controllers\Api\Leads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Leads\Fields\StoreRequest;
use App\Http\Requests\Api\Leads\Fields\UpdateRequest;
use App\Http\Resources\Api\Fields\FieldResource;
use App\Models\Field;
use App\Models\ListField;
use App\Models\Rule;
use Illuminate\Http\Request;

class FieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fields = Field::all();
        return FieldResource::collection($fields);
    }

    /**
     * Store a newly created resource in storage.
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
        $data['CRM_TYPE'] = "CRM_LEAD";
        $data['EDIT_FORM_LABEL'] = $data['LIST_COLUMN_LABEL'];
        $data['XML_ID'] = $data['FIELD_NAME'];

        $field = Field::firstOrCreate([
            'LIST_COLUMN_LABEL' => $data['LIST_COLUMN_LABEL'],
            'CRM_TYPE' => $data['CRM_TYPE'],
        ], $data);

        if ($data['USER_TYPE_ID'] == "enumeration" && !empty($data['LIST'])) {

            $lists = json_decode($data['LIST']);
//            $lists = $data['LIST'];

            foreach ($lists as $list) {
                if(!isset($list->VALUE)){
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
            return new FieldResource($field);
        } else {
            return array('data' => ['status' => false]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $field = Field::find($id);

        if ($field) {
            return new FieldResource($field);
        } else {
            return array('data' => [
                'status' => false,
                'messages' => 'Field is not found',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $field = Field::find($id);

        if ($field) {
            $data['EDIT_FORM_LABEL'] = $data['LIST_COLUMN_LABEL'];
            $field->update($data);
            $field->refresh();

            if (!empty($data['LIST'])) {

                $field->lists()->delete();
               // return 222;
                $lists = json_decode($data['LIST']);
                foreach ($lists as $list) {
                    if(!isset($list->VALUE)){
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $field = Field::find($id);

        if ($field) {

            $rules = Rule::all();

            foreach ($rules as $rule){
                if($rule->field_id == $id){
                    $rule->delete();
                    continue;
                }
                $rule_arr =  json_decode($rule->rule);
                $new_rule = array();
                foreach ($rule_arr as $value){
                    if ($value->id == $id){
                        continue;
                    }else{
                        $new_rule[] = $value;
                    }
                }
                $rule->update([
                    'rule' => json_encode($new_rule)
                ]);
            }

            $field->lists()->delete();
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
     * Remove the specified resource from storage.
     */
    public function update_index(Request $request)
    {
        $data = $request->input();

        if(empty($data['index'])){

            return array('data' => [
                'status' => false,
                'messages' => "index is empty",
            ]);
        }

        $indexs = json_decode($data['index']);

        $count_fields = Field::where('CRM_TYPE', "CRM_LEAD")->count();

        if($count_fields != count($indexs)){
            return array('data' => [
                'status' => false,
                'messages' => "The number of fields is not equal to the number of indexes",
            ]);
        }

        foreach ($indexs as $index){

            $field = Field::find($index->field_id);

            if(!$field){
                return array('data' => [
                    'status' => false,
                    'messages' => "Field ID = $index->field_id is not found",
                ]);
            }

            $field->update([
                'index' => $index->index
            ]);
        }

        $fields = Field::where('CRM_TYPE', "CRM_LEAD")->get();

        return FieldResource::collection($fields);
    }
}
