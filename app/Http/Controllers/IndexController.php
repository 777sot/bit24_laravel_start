<?php

namespace App\Http\Controllers;

use App\Http\Services\FieldsBTX;
use App\Http\Services\MyB24;
use App\Http\Services\Services;
use App\Models\Field;
use App\Models\Rule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{

    public function index(Request $request)
    {
//        $fields_CRM_LEAD = Services::refreshCRM_LEADfields($request);
//        $fields_CRM_DEAL = Services::refreshCRM_DEALfields($request);
//        $fields_CRM_CONTACT = Services::refreshCRM_CONTACTfields($request);
//        $fields_CRM_COMPANY = Services::refreshCRM_COMPANYfields($request);
//        $fields_CRM_QUOTE = Services::refreshCRM_QUOTEfields($request);

//        $result = MyB24::getCallB24configReset($request, 'crm.lead.details.configuration.reset');
//        $result = MyB24::getCallB24config($request, 'crm.lead.details.configuration.set');

        $result1 = FieldsBTX::AddTextField($request);
        $result2 = FieldsBTX::AddListField($request);

        dump($result1);
        dd($result2);


        Log::info("INDEX");


        $rules_fields = array(
            0 => 'РАВНО',
            1 => 'НЕ РАВНО',
            2 => 'НЕ ЗАПОЛНЕНО',
            3 => 'ЗАПОЛНЕНО',
            4 => 'СОДЕРЖИТ',
            5 => 'НЕ СОДЕРЖИТ',
        );

//TYPE_FIELD = 1
//        $rule = [];
//        $rule['id'] = 1;
//        $rule['rule'] = 0;
//        $rule['text'] = "aaa";
//
//
//        $field = Rule::create([
//            'field_id' => 3,
//            'rule' => json_encode($rule),
//            'rule_type' => 1,
//            'show' => 1,
//        ]);

        //---------
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

//
//
//        $field = Rule::create([
//            'field_id' => 4,
//            'rule' => json_encode($rule),
//            'rule_type' => 2,
//            'show' => 1,
//        ]);

//        $rule_one = Rule::first();
//        $rule_dec = json_decode($rule_one->rule, true);
//        dd($rule_dec[0]['id']);


        return view('btx.index');
    }

    public function install(Request $request)
    {

        $install_result = MyB24::installApp($request);

        $result = MyB24::placementCallB24($request, 'userfieldtype.add');

        $result_bind = MyB24::bindCallB24($request, 'event.bind', 'ONCRMLEADADD');
        $result_bind_2 = MyB24::bindCallB24($request, 'event.bind', 'ONCRMLEADUPDATE');

        Log::info($result_bind);
        Log::info($result_bind_2);


//        $result = CRest::call(
//            'event.bind',
//            [
//                'EVENT' => 'ONCRMCONTACTADD',
//                'HANDLER' => $handlerBackUrl,
//                'EVENT_TYPE' => 'online'
//            ]
//        );


        return view('btx.install', compact("install_result"));
    }

    public function handler(Request $request)
    {
        Log::info("HANDLER");
        Log::info($request->input());
        Log::info($request->input('data.FIELDS.ID'));
        Log::info($request->input('data.FIELDS'));
        Log::info("HANDLER");

        $event = $request->input('event');

        if(in_array($event, ['0' => 'ONCRMLEADADD', '1' => 'ONCRMLEADUPDATE'])){}

            $result = MyB24::setLeadsCallB24_test($request, 'crm.lead.update');
        Log::info($result);


        return 'handler';
    }

    public function leads(Request $request)
    {
        $domain = $request->input('DOMAIN');
        $auth_id = $request->input('AUTH_ID');
        $id = $request->input('LEADS.ID');

        $result = MyB24::setLeadsCallB24($request, 'crm.lead.update', $request);
        $fields = Field::all();
        return view('btx.placement', compact('id','fields', 'domain', 'auth_id'));
    }

    public function placement(Request $request)
    {
        $result = MyB24::placementCallB24upd($request, 'userfieldtype.update');
//        $result = MyB24::getCallB24configReset($request, 'crm.contact.details.configuration.reset');
//        $result = MyB24::getCallB24config($request, 'crm.lead.details.configuration.set');

//        dd($request->input());

        $domain = $request->input('DOMAIN');
        $auth_id = $request->input('AUTH_ID');
        $id = Services::getLeads($request, 'id');

        $fields = Field::all();
//        dd($fields);
        return view('btx.placement', compact('id','fields', 'domain', 'auth_id'));
    }
}
