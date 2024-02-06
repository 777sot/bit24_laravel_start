<?php

namespace App\Http\Services;

class Services
{
    public static function getLeads($request, $type = 'all')
    {
        $data = [];
        $data = json_decode($request->input('PLACEMENT_OPTIONS'), true);
        if($type == 'id'){
            return $data['ENTITY_VALUE_ID'];
        }
        return $data;
    }
}
