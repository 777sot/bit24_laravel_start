@extends('app_free')

@section('content')
    <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12">
            <h3 id="el1"></h3>
            <h3 id="elem">****</h3>
            <button type="button" id="check_btn" class="btn btn-danger">Отправить</button>
        </div>
    </div>
    <button type="button" id="values_btn" class="btn btn-danger">СОХРАНИТЬ ЗНАЧЕНИЯ</button>
    <div
        class="grid h-full w-full justify-items-center overflow-hidden place-items-start justify-items-center p-6 py-8 sm:p-8 lg:p-12">
        <form method="POST" class="w-full max-w-sm space-y-8" action="{{ route('leads') }}">
            @foreach($fields as $k => $field)
                @if($field->USER_TYPE_ID == 'string')

                    <div class="mt-2">
                        <h3>{{$field->USER_TYPE_ID}}</h3>
                        <label for="{{$field->FIELD_NAME}}"
                               class="block text-sm font-medium leading-6 text-gray-900">{{$field->id}} {{$field->LIST_COLUMN_LABEL}}</label>
                        <input data-id="{{$field->id}}" type="text" name="{{$field->FIELD_NAME}}"
                               id="{{$field->FIELD_NAME}}"
                               class="my_frm f{{$k}} block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                               value="">
                    </div>
                @elseif($field->USER_TYPE_ID == 'enumeration')

                    <div class="mt-2">
                        <h3>{{$field->USER_TYPE_ID}}</h3>
                        <label for="{{$field->FIELD_NAME}}"
                               class="block text-sm font-medium leading-6 text-gray-900">{{$field->id}} {{$field->LIST_COLUMN_LABEL}}</label>
                        @if($field->MULTIPLE == true)
                            <select class="my_frm" id="{{$field->FIELD_NAME}}" data-id="{{$field->id}}" name="{{$field->FIELD_NAME}}" multiple>
                                <!--Supplement an id here instead of using 'name'-->
                                @foreach($field->lists as $list)
                                    <option value="{{$list->id}}">{{$list->value}}</option>
                                @endforeach
                            </select>
                        @else
                            <select class="my_frm" id="{{$field->FIELD_NAME}}" data-id="{{$field->id}}"
                                    name="{{$field->FIELD_NAME}}">
                                <!--Supplement an id here instead of using 'name'-->
                                @foreach($field->lists as $list)
                                    <option value="{{$list->id}}">{{$list->value}}</option>
                                @endforeach
                            </select>
                        @endif

                    </div>
                @endif
            @endforeach
            {{--            <label for="TITLE" class="block text-sm font-medium leading-6 text-gray-900">TITLE222</label>--}}
            {{--            <div class="mt-2">--}}
            {{--                <input type="text" name="LEADS[TITLE]" id="TITLE" autocomplete="given-name"--}}
            {{--                       class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">--}}
            {{--                <input type="hidden" name="LEADS[ID]" value="{{ $id }}">--}}
            {{--            </div>--}}

            <input type="hidden" name="LEADS[ID]" value="{{ $id }}">
            <input type="hidden" name="DOMAIN" value="{{ $domain }}">
            <input type="hidden" name="AUTH_ID" value="{{ $auth_id }}">
{{--            <div class="mt-6 flex items-center justify-end gap-x-6">--}}
{{--                <button--}}
{{--                    class="relative isolate inline-flex items-center justify-center gap-x-2 rounded-lg border text-base/6 font-semibold px-[calc(theme(spacing[3.5])-1px)] py-[calc(theme(spacing[2.5])-1px)] sm:px-[calc(theme(spacing.3)-1px)] sm:py-[calc(theme(spacing[1.5])-1px)] sm:text-sm/6 focus:outline-none data-[focus]:outline data-[focus]:outline-2 data-[focus]:outline-offset-2 data-[focus]:outline-blue-500 data-[disabled]:opacity-50 [&amp;>[data-slot=icon]]:-mx-0.5 [&amp;>[data-slot=icon]]:my-0.5 [&amp;>[data-slot=icon]]:size-5 [&amp;>[data-slot=icon]]:shrink-0 [&amp;>[data-slot=icon]]:text-[--btn-icon] [&amp;>[data-slot=icon]]:sm:my-1 [&amp;>[data-slot=icon]]:sm:size-4 forced-colors:[--btn-icon:ButtonText] forced-colors:data-[hover]:[--btn-icon:ButtonText] border-transparent bg-[--btn-border] dark:bg-[--btn-bg] before:absolute before:inset-0 before:-z-10 before:rounded-[calc(theme(borderRadius.lg)-1px)] before:bg-[--btn-bg] before:shadow dark:before:hidden dark:border-white/5 after:absolute after:inset-0 after:-z-10 after:rounded-[calc(theme(borderRadius.lg)-1px)] after:shadow-[shadow:inset_0_1px_theme(colors.white/15%)] after:data-[active]:bg-[--btn-hover-overlay] after:data-[hover]:bg-[--btn-hover-overlay] dark:after:-inset-px dark:after:rounded-lg before:data-[disabled]:shadow-none after:data-[disabled]:shadow-none text-white [--btn-bg:theme(colors.zinc.900)] [--btn-border:theme(colors.zinc.950/90%)] [--btn-hover-overlay:theme(colors.white/10%)] dark:text-white dark:[--btn-bg:theme(colors.zinc.600)] dark:[--btn-hover-overlay:theme(colors.white/5%)] [--btn-icon:theme(colors.zinc.400)] data-[active]:[--btn-icon:theme(colors.zinc.300)] data-[hover]:[--btn-icon:theme(colors.zinc.300)] cursor-default"--}}
{{--                    type="submit" data-headlessui-state="">Сохранить<span--}}
{{--                        class="absolute left-1/2 top-1/2 size-[max(100%,2.75rem)] -translate-x-1/2 -translate-y-1/2 [@media(pointer:fine)]:hidden"--}}
{{--                        aria-hidden="true"></span></button>--}}
{{--            </div>--}}

        </form>
    </div>
@endsection
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    window.onload = function () {

        let btn = document.getElementById("check_btn");
        let btn_val = document.getElementById("values_btn");
        //ОТПРАВКА ЗНАЧЕНИЙ, ПОЛУЧЕНИЕ ПРАВИЛ
        btn.addEventListener("click", function (e) {

            const my_frm = document.querySelectorAll(".my_frm");
            const elem = document.querySelector("#elem");

            var obj = {};
            my_frm.forEach(el => {

                // obj[el.dataset.id] = el.value;
                // el.style.display = "none";
            })

            // document.getElementById("el1").innerHTML = my_frm[3].dataset.id;

            axios.post('/api/rules', obj).then(res => {
                document.getElementById("el1").innerHTML = JSON.stringify(res.data);

                for (k in res.data) {
                    for (key in res.data[k]) {

                        // elem.innerHTML = JSON.stringify(res.data[k][key]);
                        // elem.innerHTML = JSON.stringify(key);
                        // if(res.data[k][key]['show'] == 0){
                        //     document.querySelector(`.f${key}`).style.display = "none";
                        // }else{
                        //     document.querySelector(`.f${key}`).style.display = "block";
                        // }

                    }


                }
                //    document.getElementById("el1").innerHTML = my_frm[0].value;
            })
                .catch(err => {
                    document.getElementById("el1").innerHTML = err
                });
        });

        //СОХРАНЕНИЕ ЗНАЧЕНИЙ
        btn_val.addEventListener("click", function (e) {
            console.log(7890);
            // var select = document.querySelector("#multi");
            // console.log(select.hasAttribute('multiple'))
            // const selectedOptions = [];
            //
            // for (const option of select.options) {
            //     if (option.selected) {
            //         selectedOptions.push(option.value);
            //     }
            // }
            //
            // console.log(selectedOptions);
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
                console.log(JSON.stringify(res.data));
                console.log(987);
            })
                .catch(err => {
                    console.log(err);
                });
        });
    }


</script>
