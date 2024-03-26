<?php

namespace App\Http\Controllers\Phones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Phone\StoreRequest;
use App\Http\Services\MyB24;
use App\Http\Services\PhoneServices;
use App\Models\Phone;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    /**
     * ВЫВОД ГЛАВНОЙ СТРАНИЦЫ С ФОРМОЙ
     */
    public function index(Request $request)
    {
        //ПОЛУЧЕМ member_id ПОЛЬЗОВАТЕЛЯ
        $member_id = $request->input('member_id');
        //МЕТОД ОБНОВЛЕНИЯ ТОКЕНА
        $res = PhoneServices::CallB24_refresh_token($member_id);
        if (!$res) {
            return false;
        }
        //ПОЛУЧЕМ НАСТРОЙКИ ФОРМЫ ПОЛЬЗОВАТЕЛЯ
        $phone = Phone::where('member_id', $member_id)->first();

        if ($phone) {
            $automatic = $phone->automatic;
            $format = $phone->format;
        } else {
            $automatic = '';
            $format = '';
        }

        $errors = [];
        $all_data = [];

        return view('btx.index_phone', compact('member_id', 'automatic', 'format', 'errors', 'all_data'));
    }
    /**
     * ИНСТАЛЯЦИЯ БИТРИКСА
     */
    public function install(Request $request)
    {
        //INSTALL
        $install_result = MyB24::installApp($request);
        //ПОЛУЧЕМ member_id ПОЛЬЗОВАТЕЛЯ
        $member_id = $request->input('member_id');
        if ($member_id){
            //ДОБАВЛЯЕМ СОБЫТИЯ
            $result_bind_1 = MyB24::bindPhoneCallB24('event.bind', 'ONCRMLEADADD', $member_id);
            $result_bind_2 = MyB24::bindPhoneCallB24('event.bind', 'ONCRMLEADUPDATE', $member_id);

            $result_bind_3 = MyB24::bindPhoneCallB24('event.bind', 'ONCRMCONTACTADD', $member_id);
            $result_bind_4 = MyB24::bindPhoneCallB24('event.bind', 'ONCRMCONTACTUPDATE', $member_id);

            $result_bind_4 = MyB24::bindPhoneCallB24('event.bind', 'ONCRMCOMPANYADD', $member_id);
            $result_bind_5 = MyB24::bindPhoneCallB24('event.bind', 'ONCRMCOMPANYUPDATE', $member_id);
        }


        return view('btx.install', compact("install_result"));
    }
    /**
     * ОБНОВЛЕНИЕ ИЛИ СОЗДАНИЕ НАСТРОЕК ФОРМАТИРОВАНИЯ НОМЕРА
     */
    public function store(StoreRequest $request)
    {
        //ПРОВЕРКА ВАЛИДАЦИИ
        $data = $request->validated();
        //НАХОДИМ ПОЛЬЗОВАТЕЛЯ
        $setting = Setting::where('member_id', $data['member_id'])->first();
        //ДОБАВЛЯЕМ/ОБНОВЛЯЕМ ДАННЫЕ В ТАБЛИЦУ Phone
        if ($setting) {
            $results = Phone::updateOrCreate([
                'member_id' => $data['member_id'],
            ], [
                'member_id' => $data['member_id'],
                'format' => $data['format'],
                'automatic' => $data['automatic'] ?? ''
            ]);
            //ПЕРЕМЕННЫЕ ДЛЯ ВЫВОДА НА СТРАНИЦУ
            $member_id = $data['member_id'];
            $format = $data['format'];
            $automatic = $data['automatic'] ?? '';
            $errors = '';
            $all_data = [];

            return view('btx.index_phone', compact('member_id', 'automatic', 'format', 'errors', 'all_data'));
        } else {
            //ВЫВОД ОШИБКИ ЕСЛИ ПОЛЬЗОВАТЕЛЬ НЕ НАЙДЕН
            return [];
        }
    }
    /**
     * ОБРАБОТКА СОБЫТИЙ
     */
    public function handler(Request $request)
    {
        //ПОЛУЧЕМ ДАННЫЕ ДЛЯ ОБРАБОТКИ СОБЫТИЯ
        $event = $request->input('event');
        $id = $request->input('data.FIELDS.ID');
        $member_id = $request->input('auth.member_id');

        $phone_settings = Phone::where('member_id', $member_id)->first();
        if (!$phone_settings) {
            return false;
        }

        $format = $phone_settings->format;
        $automatic = $phone_settings->automatic;

        $crm_type = '';
        //ОПРЕДЕЛЯЕМ СУЩНОСТЬ ДЛЯ ОБРАБОТКИ СОБЫТИЯ
        if (in_array($event, ['0' => 'ONCRMLEADADD', '1' => 'ONCRMLEADUPDATE'])) {
            $crm_type = 'CRM_LEAD';
        } elseif (in_array($event, ['0' => 'ONCRMCONTACTADD', '1' => 'ONCRMCONTACTUPDATE'])) {
            $crm_type = 'CRM_CONTACT';
        } elseif (in_array($event, ['0' => 'ONCRMCOMPANYADD', '1' => 'ONCRMCOMPANYUPDATE'])) {
            $crm_type = 'CRM_COMPANY';
        }
        //ПРОВЕРЯЕМ ПАРАМЕТР АВТОМАТИЧЕСКОГО ОБНОВЛЕНИЯ
        if (!empty($automatic) && $crm_type) {
            //МЕТОД ОБНОВЛЕНИЯ ТОКЕНА
            $res = PhoneServices::CallB24_refresh_token($member_id);
            if (!$res) {
                return false;
            }
            //ПОЛУЧАЕМ НОМЕРА ПО ID СУЩНОСТИ
            $get = PhoneServices::getPhoneCallB24($crm_type, $id, $member_id);
            $phones = $get['result']['PHONE'];
            if (isset($get['result']['PHONE'])) {
                $new_phones = [];
                foreach ($phones as $phone) {
                    //ПРИВОДИМ НОМЕРА К ЕДИНОМУ ФОРМАТУ
                    $result = PhoneServices::check_phone_format($phone['VALUE'], (string)$format);
                    $phone['VALUE'] = $result['VALUE'];
                    $new_phones[] = $phone;
                }
                //МЕНЯЕМ ФОРМАТ НОМЕРА
                $set = PhoneServices::setPhoneCallB24($crm_type, $id, $new_phones, $member_id);
            }

        }

        return true;
    }
    /**
     * ОБНОВЛЕНИЕ ФОРМАТА НОМЕРОВ
     */
    public function phonesupdate(Request $request)
    {
        //
        $crm_title = [
            'url' => [
                'CRM_LEAD' => 'lead',
                'CRM_CONTACT' => 'contact',
                'CRM_COMPANY' => 'company'
            ],
            'title' => [
                'CRM_LEAD' => 'Лидах',
                'CRM_CONTACT' => 'Контактах',
                'CRM_COMPANY' => 'Компаниях'
            ]
        ];
        //СЧЕТЧИК ЗАПРОСОВ
        $req_counter = 0;

        $member_id = $request->input('member_id');
        if (!$member_id) {
            return false;
        }

        $bit = Setting::where('member_id', $member_id)->first();

        if (!$bit) {
            return false;
        }
        //МЕТОД ОБНОВЛЕНИЯ ТОКЕНА
        $res = PhoneServices::CallB24_refresh_token($member_id);
        if (!$res) {
            return false;
        }

        $req_counter++;
        $site = $bit->domain;
        $errors = [];
        $phone_settings = Phone::where('member_id', $member_id)->first();

        if (!$phone_settings) {
            return false;
        }

        $format = $phone_settings->format;
        $automatic = $phone_settings->automatic;

        $phone_settings->automatic = '';
        $phone_settings->save();

        //СПИСОК СУЩНОСТЕЙ
        $crm_array = array('CRM_COMPANY', 'CRM_LEAD', 'CRM_CONTACT');

        $all_data = [];
        //ПЕРЕБИРАЕМ СУЩНОСТИ И МЕНЯЕМ ФОРМАТ НОМЕРА
        foreach ($crm_array as $crm_type) {
            sleep(2);
            //ЗАПРОСЫ НА ПОЛУЧЕНИЯ НОМЕРОВ
            $results = PhoneServices::getBatchPhoneCallB24($crm_type, $member_id);
            $req_counter += $results['req_counter'];
            if (empty($results['data'])) {
                continue;
            };
            //ПРОВЕРЯЕМ ПОЛУЧЕНИЕ ОТВЕТА
            if (PhoneServices::check_results($results['data'])) {
                $data = [];
                $data['result'] = [];
                $data['errors'] = [];
                $data['update'] = [];


                $result = $results['data']['result']['result'];
                //МАССИВ ДЛЯ ИЗМЕНЕНИЯ ДАННЫХ
                $result_up['result'] = [];
                //МАССИВ ОШИБОК ДАННЫХ
                $result_up['errors'] = [];
                //МАССИВ ОБНОВЛЕННЫХ НОМЕРОВ
                $result_up['update'] = [];
                //ФОРМИРУЕМ ИТОГОВЫЙ МАССИВ
                foreach ($result as $item50) {
                    $result_up = PhoneServices::update_item50($item50, $crm_type, $format);
                    $data['result'] = [...$data['result'], ...$result_up['result']];
                    $data['errors'] = [...$data['errors'], ...$result_up['errors']];
                    $data['update'] = [...$data['update'], ...$result_up['update']];
                }
                //МАССИВ ВЫВОДА ДАННЫХ
                $all_data[$crm_type] = $data;

                $data_request = [];
                //ЗАПРОСЫ В БИТРИКС ДЛЯ ДОРМИРОВАНИЯ ССЫЛОК
                foreach ($data['result'] as $item) {
                    $data_request[] = PhoneServices::get_request_crm($item, $crm_type);
                }
                //МАССИВ ССЫЛОК
                $requests = array();
                $counter = 0;
                //ФОРМИРУЕМ ПАКЕТ ЗАПРОСОВ
                for ($i = 0; $i < count($data_request); $i++) {
                    $requests[$counter][] = $data_request[$i];
                    if ($i === 19) {
                        $counter++;
                    } elseif ($i - ($counter * 20) === 19) {
                        $counter++;
                    }
                }

                $req_counter += count($requests);
                //ОТПРАВЛЯЕМ ПАКЕТНЫЕ ЗАПРОСЫ В БИТРИКС ДЛЯ ИЗМЕНЕНИЯ
                foreach ($requests as $req50) {
                    $response = PhoneServices::setBatchPhoneCallB24($req50, $member_id);
                }
            }

        }
        //ВОЗВРАЩАЕМ ЗНАЧЕНИЕ НАСТРОЙКИ
        $phone_settings_fresh = Phone::where('member_id', $member_id)->first();
        $phone_settings_fresh->automatic = $automatic;
        $phone_settings_fresh->save();

        return view('btx.index_phone', compact('member_id', 'crm_title', 'automatic', 'format', 'errors', 'all_data', 'site'));
    }
}
