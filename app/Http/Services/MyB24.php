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
     * @return boolean
     * @var $isInstall  boolean true if install app by installApp()
     * @var $arSettings array settings application
     */

    private static function setAppSettings($arSettings, $isInstall = false)
    {
        $return = false;
        if (is_array($arSettings)) {
            $oldData = static::getAppSettings();
            if ($isInstall != true && !empty($oldData) && is_array($oldData)) {
                $arSettings = array_merge($oldData, $arSettings);
            }
            $return = static::setSettingData($arSettings);
        }
        return $return;
    }

    /**
     * Can overridden this method to change the data storage location.
     *
     * @return boolean is successes save data for setSettingData()
     * @var $arSettings array settings application
     */

    protected static function setSettingData($arSettings)
    {
        return (boolean)file_put_contents(__DIR__ . '/settings.json', static::wrapData($arSettings));
    }

    /**
     * @return string json_encode with encoding
     * @var $debag boolean
     *
     * @var $data mixed
     */
    protected static function wrapData($data, $debag = false)
    {
        if (defined(env('C_REST_CURRENT_ENCODING'))) {
            $data = static::changeEncoding($data, true);
        }
        $return = json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);


        return $return;
    }

    /**
     * @return mixed setting application for query
     */

    private static function getAppSettings()
    {
        if (defined(env("C_REST_WEB_HOOK_URL")) && !empty(env("C_REST_WEB_HOOK_URL"))) {
            $arData = [
                'client_endpoint' => env("C_REST_WEB_HOOK_URL"),
                'is_web_hook' => 'Y'
            ];
            $isCurrData = true;
        } else {
            $arData = static::getSettingData();
            $isCurrData = false;
            if (
                !empty($arData['access_token']) &&
                !empty($arData['domain']) &&
                !empty($arData['refresh_token']) &&
                !empty($arData['application_token']) &&
                !empty($arData['client_endpoint'])
            ) {
                $isCurrData = true;
            }
        }

        return ($isCurrData) ? $arData : false;
    }

    static function CallB24($domain, $auth_id, $method, $data){

        $url = 'https://' . $domain . '/rest/' . $method . '.json';
        $response = Http::post($url, [
            'auth' => $auth_id,
            'fields' => $data
        ]);

        return $response->json();
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
    static function getLeadCallB24(Request $request, $method, $id)
    {
        $domain = $request->input('DOMAIN');
        $auth_id = $request->input('AUTH_ID');
        $url = 'https://' . $domain . '/rest/' . $method . '.json';
        $response = Http::post($url, [
            'auth' => $auth_id,
            'ID' => $id
        ]);

        return $response->json();
    }

    static function getCallB24config(Request $request, $method)
    {
        $domain = $request->input('DOMAIN');
        $auth_id = $request->input('AUTH_ID');
        //  $method = 'crm.company.list';
        $url = 'https://' . $domain . '/rest/' . $method . '.json';
        $response = Http::post($url, [
            'auth' => $auth_id,
            "scope" => "P",
            "data" =>
                [
                    [
                        "name" => "main",
                        "title" => "Общие сведения 1",
                        "type" => "section",
                        "elements" =>
                            [
                                ["name" => "TITLE"],
                                ["name" => "STATUS_ID"],
                                ["name" => "NAME"],
                                ["name" => "BIRTHDATE"],
                                ["name" => "POST"],
                                ["name" => "PHONE"],
                                ["name" => "EMAIL"]
                            ]
                    ],
                    [
                        "name" => "additional",
                        "title" => "Дополнительно",
                        "type" => "section",
                        "elements" =>
                            [
                                ["name" => "SOURCE_ID"],
                                ["name" => "SOURCE_DESCRIPTION"],
                                ["name" => "OPENED"],
                                ["name" => "ASSIGNED_BY_ID"],
                                ["name" => "ASSIGNED_BY_ID"],
                                ["name" => "OBSERVER"],
                                ["name" => "COMMENTS"]
                            ]
                    ],
                ],
        ]);


        return $response->json();
    }

    static function getCallB24configReset(Request $request, $method)
    {
        $domain = $request->input('DOMAIN');
        $auth_id = $request->input('AUTH_ID');
        //  $method = 'crm.company.list';
        $url = 'https://' . $domain . '/rest/' . $method . '.json';
        $response = Http::post($url, [
            'auth' => $auth_id,
            "scope" => "P",
        ]);


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
    static function setLeadsCallB24_test(Request $request, $method)
    {
        $domain = $request->input('auth.domain');
        $auth_id = $request->input('auth.access_token');
        $id = $request->input('data.FIELDS.ID');

        $url = 'https://' . $domain . '/rest/' . $method . '.json';
        $response = Http::post($url, [
            'auth' => $auth_id,
            "id" => $id,
            'fields' => [
                'TITLE' => "New Test - ".$id,
                "NAME" => "NAME"
            ]
        ]);

        return $response->json();
    }

    static function placementCallB24upd(Request $request, $method)
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

    static function placementCallB24(Request $request, $method)
    {
        $domain = $request->input('DOMAIN');
        $auth_id = $request->input('AUTH_ID');

        $url = 'https://' . $domain . '/rest/' . $method . '.json';

        $response = Http::post($url,
            [
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

    static function bindCallB24(Request $request, $method, $event){
        $domain = $request->input('DOMAIN');
        $auth_id = $request->input('AUTH_ID');

        $url = 'https://' . $domain . '/rest/' . $method . '.json';

        $response = Http::post($url,
            [
                'auth' => $auth_id,
                'EVENT' => $event,
                'HANDLER' => "https://bitb24.ru/handler",
                'EVENT_TYPE' => 'online'
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

        if ($event == 'ONAPPINSTALL' && !empty($auth_id)) {
            $result['install'] = static::setAppSettings($auth_id, true);
        } elseif ($plasement == 'DEFAULT') {
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
