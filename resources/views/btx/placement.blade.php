@extends('app_free')
@section('content')
    <div
        class="grid h-full w-full justify-items-center overflow-hidden place-items-start justify-items-center p-6 py-8 sm:p-8 lg:p-12">
        <form method="POST" class="w-full max-w-sm space-y-8" action="{{ route('leads') }}">
            @foreach($fields as $k => $field)
                @if($field->USER_TYPE_ID == 'string')
                    <div class="mt-1">
                        <label for="{{$field->FIELD_NAME}}"
                               class="block text-sm font-medium leading-6 text-gray-900">{{$field->id}} {{$field->LIST_COLUMN_LABEL}}</label>
                        <input data-id="{{$field->id}}" type="text" name="{{$field->FIELD_NAME}}"
                               id="{{$field->FIELD_NAME}}"
                               class="my_frm f{{$k}} block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                               value="">
                    </div>
                @elseif($field->USER_TYPE_ID == 'enumeration')
                    <div class="mt-1">
                        <label for="{{$field->FIELD_NAME}}"
                               class="block text-sm font-medium leading-6 text-gray-900">{{$field->id}} {{$field->LIST_COLUMN_LABEL}}</label>
                        @if($field->MULTIPLE == true)
                            <select class="my_frm" id="{{$field->FIELD_NAME}}" data-id="{{$field->id}}"
                                    name="{{$field->FIELD_NAME}}" multiple>
                                <!--Supplement an id here instead of using 'name'-->
                                @foreach($field->lists as $list)
                                    <option class="op{{$list->BTX_ID}}"
                                            value="{{$list->BTX_ID}}">{{$list->value}}</option>
                                @endforeach
                            </select>
                        @else
                            <select class="my_frm" id="{{$field->FIELD_NAME}}" data-id="{{$field->id}}"
                                    name="{{$field->FIELD_NAME}}">
                                <!--Supplement an id here instead of using 'name'-->
                                @foreach($field->lists as $list)
                                    <option value="{{$list->BTX_ID}}">{{$list->value}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                @endif
            @endforeach
        </form>
        <button type="button" id="values_btn" class="btn btn-danger">СОХРАНИТЬ ЗНАЧЕНИЯ</button>
    </div>
@endsection
<script src="//api.bitrix24.com/api/v1/"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    window.onload = function () {
        var b24_member_id;
        var b24_placement_info;
        var url_set;
        var url_get;
        BX24.init(function(){
            console.log('Auth',BX24.getAuth());
            let dataB24 = BX24.getAuth();
            console.log('member_id', dataB24.member_id );
            console.log('placement.info()', BX24.placement.info());
            b24_placement_info = BX24.placement.info();
            console.log('ENTITY_ID', b24_placement_info.options.ENTITY_ID);
            switch (b24_placement_info.options.ENTITY_ID) {
                case "CRM_CONTACT":
                    console.log("CRM_CONTACT");
                    url_set = '/laravel/api/contacts/values'
                    url_get = '/laravel/api/contacts/values/'+b24_placement_info.options.ENTITY_VALUE_ID
                    break;
                case "CRM_LEAD":
                    url_set = '/laravel/api/leads/values'
                    url_get = '/laravel/api/leads/values/'+b24_placement_info.options.ENTITY_VALUE_ID
                    break;
                case "CRM_COMPANY":
                    url_set = '/laravel/api/company/values'
                    url_get = '/laravel/api/company/values/'+b24_placement_info.options.ENTITY_VALUE_ID
                    break;
                case "CRM_DEAL":
                    url_set = '/laravel/api/deal/values'
                    url_get = '/laravel/api/deal/values/'+b24_placement_info.options.ENTITY_VALUE_ID
                    break;
                case "CRM_QUOTE":
                    url_set = '/laravel/api/quote/values'
                    url_get = '/laravel/api/quote/values/'+b24_placement_info.options.ENTITY_VALUE_ID
                    break;
                default:
                    console.log("EROOR");
            }
            member_id = dataB24.member_id;
        });

        let btn_val = document.getElementById("values_btn");
//ДОБАВЛЯЕМ И ИЗМЕНЯЕИ МЗНАЧЕНИЯ В БД
        function setValue() {
            console.log('setValue');
            var my_frm = document.querySelectorAll(".my_frm");
            var obj = {};
            const member_id = 'e06846e3d3560fffef5142c3fff0a8f6';
            obj['member_id'] = member_id;
            obj['ENTITY_VALUE_ID'] = '{{$id}}';
            my_frm.forEach(el => {
                if (el.hasAttribute('multiple') == true) {
                    var selectedOptions = [];
                    for (const option of el.options) {
                        if (option.selected) {
                            selectedOptions.push(option.value);
                        }
                    }
                    obj[el.dataset.id] = selectedOptions;
                } else {
                    obj[el.dataset.id] = el.value;
                }
            })
            console.log(obj);
            axios.post('/laravel/api/leads/values', obj).then(res => {
                // console.log(res.data);
                console.log(JSON.stringify(res.data));
                my_frm.forEach(el => {
                    el.style.display = (res.data[el.dataset.id].show == 1) ? "block" : "none";
                })

            })
                .catch(err => {
                    console.log(err);
                });
        }
        //СОХРАНЕНИЕ ЗНАЧЕНИЙ
        btn_val.addEventListener("click", function (e) {
            setValue();
        });
        //СОБЫТИЯ
        function setEvent() {
            var my_frm = document.querySelectorAll(".my_frm");
            my_frm.forEach(el => {
                el.addEventListener("change", function (e) {
                    console.log('change', el.value);
                    setValue();
                });
                el.addEventListener("input", function (e) {
                    console.log('input', el.value);
                    setValue();
                });
                el.addEventListener("select", function (e) {
                    console.log('select', el.value);
                    setValue();
                });
            })
            console.log('events.log');
        }
        //ПОДКЛЮЧАЕМ СОБЫТИЯ
        setEvent();
        //ПОЛУЧЕНИЕ ЗНАЧЕНИЙ
        function getValue() {
            const member_id = 'e06846e3d3560fffef5142c3fff0a8f6';
            var obj = {};
            obj['member_id'] = member_id;
            id = '{{$id}}';
            axios.get('/laravel/api/leads/values/' + id, {params: obj}).then(res => {
                console.log('res JSON', JSON.stringify(res.data));
                // console.log('res', res.data);
                let my_frm = document.querySelectorAll(".my_frm");
                res.data.forEach(data => {
                    console.log(data)
                    my_frm.forEach(el => {
                        if (el.hasAttribute('multiple') == true) {
                            if (data.field_id == el.dataset.id) {
                                var selectedOptions = [];
                                for (const option of el.options) {
                                    console.log('VALUE', data.VALUE);
                                    if (data.VALUE.includes(option.value)) {
                                        option.selected = true;
                                    }
                                }
                                el.style.display = (data.show == 1) ? "block" : "none";
                            }
                        } else {
                            if (data.field_id == el.dataset.id) {
                                el.value = data.VALUE
                                el.style.display = (data.show == 1) ? "block" : "none";
                            }
                        }
                    })
                })
            })
                .catch(err => {
                    console.log(err);
                });
        }
//ПОЛУЧАЕМ ЗНАЧЕНИЯ
        getValue();
    }
</script>
