@extends('app_free')

@section('content')
    <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12">
<h3 id="el1"></h3>
<h3 id="elem">****</h3>
            <button type="button" id="check_btn" class="btn btn-danger" >Отправить</button>
        </div>
    </div>
    <div
        class="grid h-full w-full justify-items-center overflow-hidden place-items-start justify-items-center p-6 py-8 sm:p-8 lg:p-12">
        <form method="POST" class="w-full max-w-sm space-y-8" action="{{ route('leads') }}">
@foreach($fields as $k => $field)
               <div class="mt-2">
                   <label for="{{$field->TITLE}}" class="block text-sm font-medium leading-6 text-gray-900">{{$field->id}} {{$field->TITLE}}</label>

                   <input data-id="{{$field->id}}" type="text" name="{{$field->TITLE}}" id="{{$field->TITLE}}"
                           class="my_frm f{{$k}} block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                   value="{{$field->id}}asdasd{{$field->id}}">
                </div>
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
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button
                    class="relative isolate inline-flex items-center justify-center gap-x-2 rounded-lg border text-base/6 font-semibold px-[calc(theme(spacing[3.5])-1px)] py-[calc(theme(spacing[2.5])-1px)] sm:px-[calc(theme(spacing.3)-1px)] sm:py-[calc(theme(spacing[1.5])-1px)] sm:text-sm/6 focus:outline-none data-[focus]:outline data-[focus]:outline-2 data-[focus]:outline-offset-2 data-[focus]:outline-blue-500 data-[disabled]:opacity-50 [&amp;>[data-slot=icon]]:-mx-0.5 [&amp;>[data-slot=icon]]:my-0.5 [&amp;>[data-slot=icon]]:size-5 [&amp;>[data-slot=icon]]:shrink-0 [&amp;>[data-slot=icon]]:text-[--btn-icon] [&amp;>[data-slot=icon]]:sm:my-1 [&amp;>[data-slot=icon]]:sm:size-4 forced-colors:[--btn-icon:ButtonText] forced-colors:data-[hover]:[--btn-icon:ButtonText] border-transparent bg-[--btn-border] dark:bg-[--btn-bg] before:absolute before:inset-0 before:-z-10 before:rounded-[calc(theme(borderRadius.lg)-1px)] before:bg-[--btn-bg] before:shadow dark:before:hidden dark:border-white/5 after:absolute after:inset-0 after:-z-10 after:rounded-[calc(theme(borderRadius.lg)-1px)] after:shadow-[shadow:inset_0_1px_theme(colors.white/15%)] after:data-[active]:bg-[--btn-hover-overlay] after:data-[hover]:bg-[--btn-hover-overlay] dark:after:-inset-px dark:after:rounded-lg before:data-[disabled]:shadow-none after:data-[disabled]:shadow-none text-white [--btn-bg:theme(colors.zinc.900)] [--btn-border:theme(colors.zinc.950/90%)] [--btn-hover-overlay:theme(colors.white/10%)] dark:text-white dark:[--btn-bg:theme(colors.zinc.600)] dark:[--btn-hover-overlay:theme(colors.white/5%)] [--btn-icon:theme(colors.zinc.400)] data-[active]:[--btn-icon:theme(colors.zinc.300)] data-[hover]:[--btn-icon:theme(colors.zinc.300)] cursor-default"
                    type="submit" data-headlessui-state="">Сохранить<span
                        class="absolute left-1/2 top-1/2 size-[max(100%,2.75rem)] -translate-x-1/2 -translate-y-1/2 [@media(pointer:fine)]:hidden"
                        aria-hidden="true"></span></button>
            </div>

        </form>
    </div>
@endsection

<script>


    window.onload = function() {
        let btn = document.getElementById("check_btn");

        btn.addEventListener("click", function (e) {

            const my_frm = document.querySelectorAll(".my_frm");
            const elem = document.querySelector("#elem");
            // elem.hidden = true;
            var obj = {};
            my_frm.forEach(el => {
                obj[el.dataset.id] = el.value;
                // el.style.display = "none";
            })

            document.getElementById("el1").innerHTML = my_frm[3].dataset.id;


            axios.post('/api/rules',obj).then(res => {
                     document.getElementById("el1").innerHTML = JSON.stringify(res.data);

                for (k in res.data) {
                    for (key in res.data[k]) {

                        // elem.innerHTML = JSON.stringify(res.data[k][key]);
                        elem.innerHTML = JSON.stringify(key);
                        if(res.data[k][key]['show'] == 0){
                            document.querySelector(`.f${key}`).style.display = "none";
                        }else{
                            document.querySelector(`.f${key}`).style.display = "block";
                        }

                    }


                }
                    //    document.getElementById("el1").innerHTML = my_frm[0].value;
                })
                .catch(err =>  {
                       document.getElementById("el1").innerHTML = err
                });
        });



    }


</script>
