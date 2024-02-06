<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MyB24
{
    /**
     * Can overridden this method to change the data storage location.
     *
     * @return array setting for getAppSettings()
     */

    protected static function getSettingData()
    {
        $return = [];

        $return['C_REST_CLIENT_ID'] = env("C_REST_CLIENT_ID");
        $return['C_REST_CLIENT_SECRET'] = env("C_REST_CLIENT_SECRET");

        return $return;
    }

    /**
     * @var $arSettings array settings application
     * @var $isInstall  boolean true if install app by installApp()
     * @return boolean
     */

    private static function setAppSettings($arSettings, $isInstall = false)
    {
        $return = false;
        if(is_array($arSettings))
        {
            $oldData = static::getAppSettings();
            if($isInstall != true && !empty($oldData) && is_array($oldData))
            {
                $arSettings = array_merge($oldData, $arSettings);
            }
            $return = static::setSettingData($arSettings);
        }
        return $return;
    }

    /**
     * Can overridden this method to change the data storage location.
     *
     * @var $arSettings array settings application
     * @return boolean is successes save data for setSettingData()
     */

    protected static function setSettingData($arSettings)
    {
        return  (boolean)file_put_contents(__DIR__ . '/settings.json', static::wrapData($arSettings));
    }

    /**
     * @var $data mixed
     * @var $debag boolean
     *
     * @return string json_encode with encoding
     */
    protected static function wrapData($data, $debag = false)
    {
        if(defined(env('C_REST_CURRENT_ENCODING')))
        {
            $data = static::changeEncoding($data, true);
        }
        $return = json_encode($data, JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT);



        return $return;
    }

    /**
     * @return mixed setting application for query
     */

    private static function getAppSettings()
    {
        if(defined(env("C_REST_WEB_HOOK_URL")) && !empty(env("C_REST_WEB_HOOK_URL")))
        {
            $arData = [
                'client_endpoint' => env("C_REST_WEB_HOOK_URL"),
                'is_web_hook'     => 'Y'
            ];
            $isCurrData = true;
        }
        else
        {
            $arData = static::getSettingData();
            $isCurrData = false;
            if(
                !empty($arData[ 'access_token' ]) &&
                !empty($arData[ 'domain' ]) &&
                !empty($arData[ 'refresh_token' ]) &&
                !empty($arData[ 'application_token' ]) &&
                !empty($arData[ 'client_endpoint' ])
            )
            {
                $isCurrData = true;
            }
        }

        return ($isCurrData) ? $arData : false;
    }
    static function getCallB24(Request $request, $method, $type = 'json')
    {
        $domain = $request->input('DOMAIN');
        $auth_id = $request->input('AUTH_ID');
        //  $method = 'crm.company.list';
        $url = 'https://' . $domain . '/rest/' . $method . '.json';
        $response = Http::post($url, [
            'auth' => $auth_id,
        ]);

        if ($type == 'array') {
            return $response->body();
        }

        return $response->json();
    }
     static function setCallB24(Request $request, $method, $data)
    {
        $domain = $request->input('DOMAIN');
        $auth_id = $request->input('AUTH_ID');
        //  $method = 'crm.company.list';

        $params = [];
        $params['id'] = $data[''];

        $url = 'https://' . $domain . '/rest/' . $method . '.json';
        $response = Http::post($url, [
            'auth' => $auth_id,
            "id" => $data,
            'fields' => [
                'TITLE' => '12312312312aaaa',
            ]
        ]);

        return $response->json();
    }
    static function setLeadsCallB24(Request $request, $method)
    {
        $domain = $request->input('DOMAIN');
        $auth_id = $request->input('AUTH_ID');

        $url = 'https://' . $domain . '/rest/' . $method . '.json';
        $response = Http::post($url, [
            'auth' => $auth_id,
            "id" => $request->input('LEADS.ID'),
            'fields' => [
                'TITLE' => $request->input('LEADS.TITLE'),
            ]
        ]);

        return $response->json();
    }

    static function placementCallB24(Request $request, $method)
    {
        $domain = $request->input('DOMAIN');
        $auth_id = $request->input('AUTH_ID');

        $url = 'https://' . $domain . '/rest/' . $method . '.json';

        $response = Http::post($url, [
            'auth' => $auth_id,
            'USER_TYPE_ID' => 'my_custom_type',
            'HANDLER' => "https://bitb24.ru/placement",
            'TITLE' => 'bitb24',
            'OPTIONS' => [
                'height' => 600,
            ]
        ]);

        return $response;

    }

    public static function installApp(Request $request)
    {
        $domain = $request->input('DOMAIN');
        $auth_id = $request->input('AUTH_ID');
        $plasement = $request->input('PLACEMENT');
        $auth_exp = $request->input('AUTH_EXPIRES');
        $app_sid = $request->input('APP_SID');
        $refresh_id = $request->input('REFRESH_ID');
        $event = $request->input('event');

        $result = [
            'rest_only' => true,
            'install' => false
        ];

        if($event == 'ONAPPINSTALL' && !empty($auth_id))
        {
            $result['install'] = static::setAppSettings($auth_id, true);
        }
        elseif($plasement == 'DEFAULT')
        {
            $result['rest_only'] = false;
            $result['install'] = static::setAppSettings(
                [
                    'access_token' => htmlspecialchars($auth_id),
                    'expires_in' => htmlspecialchars($auth_exp),
                    'application_token' => htmlspecialchars($app_sid),
                    'refresh_token' => htmlspecialchars($refresh_id),
                    'domain' => htmlspecialchars($domain),
                    'client_endpoint' => 'https://' . htmlspecialchars($domain) . '/rest/',
                ],
                true
            );
        }

//        static::setLog(
//            [
//                'request' => $request->all(),
//                'result' => $result
//            ],
//            'installApp'
//        );
        return $result;
    }
}
