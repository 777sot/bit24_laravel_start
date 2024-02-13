<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\ApiServices;
use App\Http\Services\Services;
use App\Models\Rule;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    public function rules(Request $request)
    {
        return Services::checkLeadsFields($request);

//        return response()->json($rule_field);

    }

    public function addrules(Request $request, $type)
    {


        $field = ApiServices::ruleAdd($request, $type);

        return $field;

    }
}
