<?php

namespace App\Http\Controllers\Api\Help;

use App\Http\Controllers\Controller;
use App\Http\Services\Services;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function rules_fields()
    {
        return Services::rules_fields();
    }/**
     * Handle the incoming request.
     */
    public function type_fields()
    {
        return Services::type_fields();
    }

    public function rule_type()
    {
        return Services::rule_type();
    }
}
