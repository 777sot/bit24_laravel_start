@extends('app_phone')
@section('content')
    <div class="tab-content" id="licenses" style="display: block;">

        <div class="row">
            <div class="col bg-form-block">
                <form class="rounded-3 pt-3 pb-5 px-4" id="form_licenses" action="https://duplicates.kalinin-oleg.ru/duplicates/main_panel?DOMAIN=leadgen24.bitrix24.ru&amp;PROTOCOL=1&amp;LANG=ru&amp;APP_SID=dd476d4288404b41c8cf5557c134e6d5&amp;member_id=fb9dc9b5b99db826faffb3efe0f8f2b8" method="POST" enctype="multipart/form-data">
                    <h3>Активация лицензии</h3>
                    <div class="form-text mt-3 mb-3">
                        В поле введите номер лицензионного ключа <br>
                    </div>
                    <div class="mb-3">
                        <div class="col-sm-10">
                            <input type="text" name="key" class="form-control crm-webform-field" id="key" placeholder="_ _ _ _ - _ _ _ _ - _ _ _ _ - _ _ _ _">
                        </div>
                    </div>
                    <br>
                    <button type="submit" name="submit" value="true" class="btn btn-lg bg-button mx-3">Активировать</button>
                </form>

            </div>
        </div></div>
@endsection
