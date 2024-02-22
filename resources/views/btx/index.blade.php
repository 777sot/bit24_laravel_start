@extends('app_free')

@section('content')
    <h1>INDEX12</h1>
    <h1 id="el1"></h1>
    <div class="grid h-full w-full justify-items-center overflow-hidden place-items-center p-6 py-8 sm:p-8 lg:p-12">
        <div class="flex gap-x-6">
            <button
                id="btn_form1" class="relative isolate inline-flex items-center justify-center gap-x-2 rounded-lg border text-base/6 font-semibold px-[calc(theme(spacing[3.5])-1px)] py-[calc(theme(spacing[2.5])-1px)] sm:px-[calc(theme(spacing.3)-1px)] sm:py-[calc(theme(spacing[1.5])-1px)] sm:text-sm/6 focus:outline-none data-[focus]:outline data-[focus]:outline-2 data-[focus]:outline-offset-2 data-[focus]:outline-blue-500 data-[disabled]:opacity-50 [&amp;>[data-slot=icon]]:-mx-0.5 [&amp;>[data-slot=icon]]:my-0.5 [&amp;>[data-slot=icon]]:size-5 [&amp;>[data-slot=icon]]:shrink-0 [&amp;>[data-slot=icon]]:text-[--btn-icon] [&amp;>[data-slot=icon]]:sm:my-1 [&amp;>[data-slot=icon]]:sm:size-4 forced-colors:[--btn-icon:ButtonText] forced-colors:data-[hover]:[--btn-icon:ButtonText] border-transparent bg-[--btn-border] dark:bg-[--btn-bg] before:absolute before:inset-0 before:-z-10 before:rounded-[calc(theme(borderRadius.lg)-1px)] before:bg-[--btn-bg] before:shadow dark:before:hidden dark:border-white/5 after:absolute after:inset-0 after:-z-10 after:rounded-[calc(theme(borderRadius.lg)-1px)] after:shadow-[shadow:inset_0_1px_theme(colors.white/15%)] after:data-[active]:bg-[--btn-hover-overlay] after:data-[hover]:bg-[--btn-hover-overlay] dark:after:-inset-px dark:after:rounded-lg before:data-[disabled]:shadow-none after:data-[disabled]:shadow-none text-white [--btn-bg:theme(colors.zinc.900)] [--btn-border:theme(colors.zinc.950/90%)] [--btn-hover-overlay:theme(colors.white/10%)] dark:text-white dark:[--btn-bg:theme(colors.zinc.600)] dark:[--btn-hover-overlay:theme(colors.white/5%)] [--btn-icon:theme(colors.zinc.400)] data-[active]:[--btn-icon:theme(colors.zinc.300)] data-[hover]:[--btn-icon:theme(colors.zinc.300)] cursor-default"
                type="button" data-headlessui-state="">Отправить<span
                    class="absolute left-1/2 top-1/2 size-[max(100%,2.75rem)] -translate-x-1/2 -translate-y-1/2 [@media(pointer:fine)]:hidden"
                    aria-hidden="true"></span></button>
        </div>  <div class="flex gap-x-6">
            <button
                id="btn_form2" class="relative isolate inline-flex items-center justify-center gap-x-2 rounded-lg border text-base/6 font-semibold px-[calc(theme(spacing[3.5])-1px)] py-[calc(theme(spacing[2.5])-1px)] sm:px-[calc(theme(spacing.3)-1px)] sm:py-[calc(theme(spacing[1.5])-1px)] sm:text-sm/6 focus:outline-none data-[focus]:outline data-[focus]:outline-2 data-[focus]:outline-offset-2 data-[focus]:outline-blue-500 data-[disabled]:opacity-50 [&amp;>[data-slot=icon]]:-mx-0.5 [&amp;>[data-slot=icon]]:my-0.5 [&amp;>[data-slot=icon]]:size-5 [&amp;>[data-slot=icon]]:shrink-0 [&amp;>[data-slot=icon]]:text-[--btn-icon] [&amp;>[data-slot=icon]]:sm:my-1 [&amp;>[data-slot=icon]]:sm:size-4 forced-colors:[--btn-icon:ButtonText] forced-colors:data-[hover]:[--btn-icon:ButtonText] border-transparent bg-[--btn-border] dark:bg-[--btn-bg] before:absolute before:inset-0 before:-z-10 before:rounded-[calc(theme(borderRadius.lg)-1px)] before:bg-[--btn-bg] before:shadow dark:before:hidden dark:border-white/5 after:absolute after:inset-0 after:-z-10 after:rounded-[calc(theme(borderRadius.lg)-1px)] after:shadow-[shadow:inset_0_1px_theme(colors.white/15%)] after:data-[active]:bg-[--btn-hover-overlay] after:data-[hover]:bg-[--btn-hover-overlay] dark:after:-inset-px dark:after:rounded-lg before:data-[disabled]:shadow-none after:data-[disabled]:shadow-none text-white [--btn-bg:theme(colors.zinc.900)] [--btn-border:theme(colors.zinc.950/90%)] [--btn-hover-overlay:theme(colors.white/10%)] dark:text-white dark:[--btn-bg:theme(colors.zinc.600)] dark:[--btn-hover-overlay:theme(colors.white/5%)] [--btn-icon:theme(colors.zinc.400)] data-[active]:[--btn-icon:theme(colors.zinc.300)] data-[hover]:[--btn-icon:theme(colors.zinc.300)] cursor-default"
                type="button" data-headlessui-state="">Отправить<span
                    class="absolute left-1/2 top-1/2 size-[max(100%,2.75rem)] -translate-x-1/2 -translate-y-1/2 [@media(pointer:fine)]:hidden"
                    aria-hidden="true"></span></button>
        </div>
    </div>




    <script src="//api.bitrix24.com/api/v1/"></script>
    <script>
        window.onload = function () {


            let data = qs.stringify({
                'LIST_COLUMN_LABEL': 'новый список 333',
                'LIST': '[ { "VALUE": "Элемент #12" }, { "VALUE": "Элемент #23" }, { "VALUE": "Элемент #3" }, { "VALUE": "Элемент #4" }, { "VALUE": "Элемент #5" } ]',
                'USER_TYPE_ID': 'enumeration',
                'MULTIPLE': '1'
            });

            let config = {
                method: 'post',
                maxBodyLength: Infinity,
                url: 'https://bitb24.ru/api/leads/fields/',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                data : data
            };

            axios.request(config)
                .then((response) => {
                    console.log(JSON.stringify(response.data));
                })
                .catch((error) => {
                    console.log(error);
                });


            console.log(BX24.getAuth());

            BX24.callMethod(
                "user.current",
                {},
                function(result)
                {
                    if(result.error())
                        console.error(result.error());
                    else
                        console.dir(result.data());
                }
            );


            axios.post('/api/rules')
                .then(res => {
                    document.getElementById("el1").innerHTML = res.data;
                })
                .catch(err => {
                    document.getElementById("el1").innerHTML = err
                });

            document.getElementById("btn_form1").addEventListener("click", function (e) {

                axios.post('{{ route('addrules.leads', 1) }}',{
                    'field_id':1,
                    'rule_type':1,
                    'rule_field_id':2,
                    'rule':2,
                    'text':'abc',
                    'show':1,
                }).then(res => {
                    document.getElementById("el1").innerHTML = JSON.stringify(res.data);

                })
                    .catch(err =>  {
                        document.getElementById("el1").innerHTML = err
                    });
            });

            document.getElementById("btn_form2").addEventListener("click", function (e) {
                var obj = [
                    {
                        'field_id':1,
                        'rule_type':2,
                        'rule_field_id':2,
                        'rule':2,
                        'text':'abc',
                        'show':1,
                },
                    {
                        'field_id':1,
                        'rule_type':2,
                        'rule_field_id':3,
                        'rule':2,
                        'text':'abcddv',
                        'show':1,
                },

                ];

                axios.post('{{ route('addrules.leads', 2) }}',obj).then(res => {
                    document.getElementById("el1").innerHTML = JSON.stringify(res.data);

                })
                    .catch(err =>  {
                        document.getElementById("el1").innerHTML = err
                    });
            });
        }


    </script>
@endsection
