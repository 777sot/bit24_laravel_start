<?php

namespace App\Http\Controllers;

use App\Http\Services\MyB24;
use App\Http\Services\Services;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index(){
        return view('btx.index');
    }

    public function install(Request $request){

        $install_result = MyB24::installApp($request);

        $result = MyB24::placementCallB24($request, 'userfieldtype.add');

        return view('btx.install', compact("install_result"));
    }

    public function handler(Request $request){

        return view('btx.placement');
    }

    public function leads(Request $request)
    {
        $domain = $request->input('DOMAIN');
        $auth_id = $request->input('AUTH_ID');
        $id = $request->input('LEADS.ID');

        $result = MyB24::setLeadsCallB24($request, 'crm.lead.update', $request);

        return view('btx.placement' , compact('id', 'domain', 'auth_id'));
    }
    public function placement(Request $request){

        $domain = $request->input('DOMAIN');
        $auth_id = $request->input('AUTH_ID');
        $id = Services::getLeads($request, 'id');

        return view('btx.placement' , compact('id', 'domain', 'auth_id'));
    }
}
