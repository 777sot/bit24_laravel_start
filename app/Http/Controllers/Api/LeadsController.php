<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\ApiServices;
use App\Http\Services\MyB24;
use App\Http\Services\Services;
use App\Models\Rule;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    public function rules(Request $request)
    {
        $data = $request->input();
//        return json_encode($data);
        return Services::checkLeadsFields($request);

    }
    public function test(Request $request)
    {
//        $data = $request->input();

//       $data = MyB24::getAppSettings();
        return 111;

    }

    public function addrules(Request $request, $type)
    {
        $field = ApiServices::ruleAdd($request, $type);
        return $field;
    }

    public function addfield(Request $request){


        $data['FIELD_NAME'] = $request->input('FIELD_NAME');
        $data['CRM_TYPE'] = $request->input('CRM_TYPE');
        $data['EDIT_FORM_LABEL'] = $request->input('EDIT_FORM_LABEL');
        $data['LIST_COLUMN_LABEL'] = $request->input('LIST_COLUMN_LABEL');
        $data['USER_TYPE_ID'] = $request->input('USER_TYPE_ID');
        $data['XML_ID'] = $request->input('XML_ID');
        $data['LIST'] = $request->input('LIST');
        $data['SETTINGS'] = $request->input('SETTINGS');

        $result = ApiServices::fileldAdd($data);

        return $result;
    }
}
