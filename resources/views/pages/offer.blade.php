@extends('app_phone')
@section('content')
    <div class="tab-content" id="feedback" style="display: block;">
        <div class="b24-form"><div id="b24-543333135921581208329420736657034" data-styles-apllied="true" class="b24-form-style-classic"><div class="b24-form-wrapper b24-form-border-bottom"><div class="b24-form-header b24-form-padding-side"><div class="b24-form-header-title">Предложение по доработкам</div> <div class="b24-form-header-description">Если у вас есть пожелание как улучшить приложение - опишите максимально подробно, чтобы вы хотели улучшить или добавить. Мы обязательно рассмотрим и дадим обратную связь.</div></div> <div class="b24-form-content b24-form-padding-side"><form method="post" novalidate="novalidate"><!----> <div><div class="b24-form-field b24-form-field-name b24-form-control-string"><div><div><div class="b24-form-control-container b24-form-control-icon-after"><input name="name" autocomplete="given-name" type="string" class="b24-form-control"> <div class="b24-form-control-label">
                                                    Имя
                                                    <span class="b24-form-control-required">*</span></div> <!----> <!----> <div class="b24-form-control-alert-message" style="display: none;">
                                                    Поле обязательно для заполнения
                                                </div></div></div> <!----> <!----></div> <!----></div><div class="b24-form-field b24-form-field-phone b24-form-control-string"><div><div><div class="b24-form-control-container b24-form-control-icon-after"><input name="phone" autocomplete="tel" type="tel" class="b24-form-control"> <div class="b24-form-control-label">
                                                    Телефон
                                                    <span class="b24-form-control-required">*</span></div> <!----> <!----> <div class="b24-form-control-alert-message" style="display: none;">
                                                    Поле обязательно для заполнения
                                                </div></div></div> <!----> <!----></div> <!----></div><div class="b24-form-field b24-form-field-email b24-form-control-string"><div><div><div class="b24-form-control-container b24-form-control-icon-after"><input name="email" autocomplete="email" type="email" class="b24-form-control"> <div class="b24-form-control-label">
                                                    E-mail
                                                    <span class="b24-form-control-required" style="display: none;">*</span></div> <!----> <!----> <div class="b24-form-control-alert-message" style="display: none;">

                                                </div></div></div> <!----> <!----></div> <!----></div><div class="b24-form-field b24-form-field-text b24-form-control-text"><div><div><div class="b24-form-control-container b24-form-control-icon-after"><textarea class="b24-form-control"></textarea> <div class="b24-form-control-label">
                                                    Комментарий
                                                    <span class="b24-form-control-required" style="display: none;">*</span></div> <!----> <div class="b24-form-control-alert-message" style="display: none;">

                                                </div></div></div> <!----> <!----></div> <!----></div></div> <div><div class="b24-form-field b24-form-field-agreement b24-form-control-agreement"><!----> <div><label class="b24-form-control-container"><input type="checkbox" onclick="this.blur()"> <span class="b24-form-control-desc"><span class="b24-form-field-agreement-link">Нажимая кнопку «Отправить», я даю свое согласие на обработку моих персональных данных, в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», на условиях и для целей, определенных в Согласии на обработку персональных данных</span></span> <span class="b24-form-control-required">*</span> <div class="b24-form-control-alert-message" style="display: none;">

                                            </div></label> <!----></div></div> <div class="v-portal" style="display: none;"></div></div> <!----> <div class="b24-form-btn-container"><!----> <!----> <div class="b24-form-btn-block"><button type="submit" class="b24-form-btn">
                                        Отправить
                                    </button></div></div> <span style="color: red; display: none;">
						Debug: fill fields
					</span></form></div> <div class="b24-form-state-container"><div class="b24-form-loader" style="display: none;"><!----> <div class="b24-form-loader-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 263 174"><g transform="translate(52.5,7)"><path id="bxSunLines" d="M79,0 C80.6568542,0 82,1.34314575 82,3 L82,22 C82,23.6568542 80.6568542,25 79,25 C77.3431458,25 76,23.6568542 76,22 L76,3 C76,1.34314575 77.3431458,0 79,0 Z M134.861,23.139 C136.032146,24.3104996 136.032146,26.2095004 134.861,27.381 L121.426,40.816 C120.248863,41.9529166 118.377746,41.9366571 117.220544,40.7794557 C116.063343,39.6222543 116.047083,37.7511367 117.184,36.574 L130.619,23.139 C131.7905,21.9678542 133.6895,21.9678542 134.861,23.139 L134.861,23.139 Z M158,79 C158,80.6568542 156.656854,82 155,82 L136,82 C134.343146,82 133,80.6568542 133,79 C133,77.3431458 134.343146,76 136,76 L155,76 C156.656854,76 158,77.3431458 158,79 Z M134.861,134.861 C133.6895,136.032146 131.7905,136.032146 130.619,134.861 L117.184,121.426 C116.40413,120.672777 116.091362,119.557366 116.365909,118.508478 C116.640455,117.45959 117.45959,116.640455 118.508478,116.365909 C119.557366,116.091362 120.672777,116.40413 121.426,117.184 L134.861,130.619 C136.032146,131.7905 136.032146,133.6895 134.861,134.861 Z M79,158 C77.3431458,158 76,156.656854 76,155 L76,136 C76,134.343146 77.3431458,133 79,133 C80.6568542,133 82,134.343146 82,136 L82,155 C82,156.656854 80.6568542,158 79,158 Z M23.139,134.861 C21.9678542,133.6895 21.9678542,131.7905 23.139,130.619 L36.574,117.184 C37.3272234,116.40413 38.4426337,116.091362 39.491522,116.365909 C40.5404103,116.640455 41.3595451,117.45959 41.6340915,118.508478 C41.9086378,119.557366 41.5958698,120.672777 40.816,121.426 L27.381,134.861 C26.2095004,136.032146 24.3104996,136.032146 23.139,134.861 Z M0,79 C0,77.3431458 1.34314575,76 3,76 L22,76 C23.6568542,76 25,77.3431458 25,79 C25,80.6568542 23.6568542,82 22,82 L3,82 C1.34314575,82 0,80.6568542 0,79 L0,79 Z M23.139,23.139 C24.3104996,21.9678542 26.2095004,21.9678542 27.381,23.139 L40.816,36.574 C41.5958698,37.3272234 41.9086378,38.4426337 41.6340915,39.491522 C41.3595451,40.5404103 40.5404103,41.3595451 39.491522,41.6340915 C38.4426337,41.9086378 37.3272234,41.5958698 36.574,40.816 L23.139,27.381 C21.9678542,26.2095004 21.9678542,24.3104996 23.139,23.139 Z" fill="#FFD110" class="bx-sun-lines-animate"></path></g> <g fill="none" fill-rule="evenodd"><path d="M65.745 160.5l.245-.005c13.047-.261 23.51-10.923 23.51-23.995 0-13.255-10.745-24-24-24-3.404 0-6.706.709-9.748 2.062l-.47.21-.196-.477A19.004 19.004 0 0 0 37.5 102.5c-10.493 0-19 8.507-19 19 0 1.154.103 2.295.306 3.413l.108.6-.609-.01A17.856 17.856 0 0 0 18 125.5C8.335 125.5.5 133.335.5 143s7.835 17.5 17.5 17.5h47.745zM166.5 85.5h69v-.316l.422-.066C251.14 82.73 262.5 69.564 262.5 54c0-17.397-14.103-31.5-31.5-31.5-.347 0-.694.006-1.04.017l-.395.013-.103-.382C226.025 9.455 214.63.5 201.5.5c-15.014 0-27.512 11.658-28.877 26.765l-.047.515-.512-.063a29.296 29.296 0 0 0-3.564-.217c-16.016 0-29 12.984-29 29 0 15.101 11.59 27.643 26.542 28.897l.458.039v.064z" stroke-opacity=".05" stroke="#000" fill="#000"></path> <circle stroke="#FFD110" stroke-width="6" cx="131.5" cy="86.5" r="44.5" class="b24-form-loader-icon-sun-ring"></circle></g></svg></div></div> <div class="b24-form-state b24-form-success" style="display: none;"><div class="b24-form-state-inner"><div class="b24-form-state-icon b24-form-success-icon"></div> <div class="b24-form-state-text"><p>Отправлено!</p> <p></p></div> <!----></div> <div class="b24-form-inner-box"></div></div> <div class="b24-form-state b24-form-error" style="display: none;"><div class="b24-form-state-inner"><div class="b24-form-state-icon b24-form-error-icon"></div> <div class="b24-form-state-text"><p></p></div> <button class="b24-form-btn b24-form-btn-border b24-form-btn-tight">
                                    Отправить еще раз
                                </button></div> <div class="b24-form-inner-box"></div></div> <div class="b24-form-state b24-form-warning" style="display: none;"><div class="b24-form-state-inner"><div class="b24-form-state-icon b24-form-warning-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 169 169"><defs><circle id="a" cx="84.5" cy="84.5" r="65.5"></circle><filter x="-.8%" y="-.8%" width="101.5%" height="101.5%" filterUnits="objectBoundingBox" id="b"><feGaussianBlur stdDeviation=".5" in="SourceAlpha" result="shadowBlurInner1"></feGaussianBlur><feOffset dx="-1" dy="-1" in="shadowBlurInner1" result="shadowOffsetInner1"></feOffset><feComposite in="shadowOffsetInner1" in2="SourceAlpha" operator="arithmetic" k2="-1" k3="1" result="shadowInnerInner1"></feComposite><feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.0886691434 0" in="shadowInnerInner1" result="shadowMatrixInner1"></feColorMatrix><feGaussianBlur stdDeviation=".5" in="SourceAlpha" result="shadowBlurInner2"></feGaussianBlur><feOffset dx="1" dy="1" in="shadowBlurInner2" result="shadowOffsetInner2"></feOffset><feComposite in="shadowOffsetInner2" in2="SourceAlpha" operator="arithmetic" k2="-1" k3="1" result="shadowInnerInner2"></feComposite><feColorMatrix values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.292285839 0" in="shadowInnerInner2" result="shadowMatrixInner2"></feColorMatrix><feMerge><feMergeNode in="shadowMatrixInner1"></feMergeNode><feMergeNode in="shadowMatrixInner2"></feMergeNode></feMerge></filter></defs><g fill="none" fill-rule="evenodd"><circle stroke-opacity=".05" stroke="#000" fill-opacity=".07" fill="#000" cx="84.5" cy="84.5" r="84"></circle><use fill="#FFF" xlink:href="#a"></use><use fill="#000" filter="url(#b)" xlink:href="#a"></use><path d="M114.29 99.648L89.214 58.376c-1.932-3.168-6.536-3.168-8.427 0L55.709 99.648c-1.974 3.25.41 7.352 4.234 7.352h50.155c3.782 0 6.166-4.103 4.193-7.352zM81.404 72.756c0-1.828 1.48-3.29 3.33-3.29h.452c1.85 0 3.33 1.462 3.33 3.29v12.309c0 1.827-1.48 3.29-3.33 3.29h-.453c-1.85 0-3.33-1.463-3.33-3.29V72.756zm7.77 23.886c0 2.274-1.892 4.143-4.194 4.143s-4.193-1.869-4.193-4.143c0-2.275 1.891-4.144 4.193-4.144 2.302 0 4.193 1.869 4.193 4.144z" fill="#000" opacity=".4"></path></g></svg></div> <div class="b24-form-state-text"><p>Форма не актуальна</p></div></div> <div class="b24-form-inner-box"></div></div></div> <!----> <div class="b24-form-sign"><select style="display: none;"><option value="sc">
                                sc
                            </option><option value="it">
                                it
                            </option><option value="en">
                                en
                            </option><option value="ru">
                                ru
                            </option><option value="la">
                                la
                            </option><option value="th">
                                th
                            </option><option value="ar">
                                ar
                            </option><option value="pl">
                                pl
                            </option><option value="fr">
                                fr
                            </option><option value="vn">
                                vn
                            </option><option value="tc">
                                tc
                            </option><option value="tr">
                                tr
                            </option><option value="ms">
                                ms
                            </option><option value="ja">
                                ja
                            </option><option value="br">
                                br
                            </option><option value="hi">
                                hi
                            </option><option value="de">
                                de
                            </option><option value="ua">
                                ua
                            </option><option value="in">
                                in
                            </option><option value="id">
                                id
                            </option></select> <div><span class="b24-form-sign-abuse"><a href="https://www.bitrix24.ru/abuse/?b24_form_id=153&amp;b24_address=https%3A%2F%2Fleadgen24.bitrix24.ru&amp;b24_form_address=https%3A%2F%2Fduplicates.kalinin-oleg.ru%2Fduplicates%2Fmain_panel%3FDOMAIN%3Dleadgen24.bitrix24.ru%26PROTOCOL%3D1%26LANG%3Dru%26APP_SID%3Ddd476d4288404b41c8cf5557c134e6d5" target="_blank" rel="nofollow" class="b24-form-sign-abuse-link">
					Сообщить о нарушении
				</a> <span title="Компания Битрикс24 не несёт ответственности за содержимое формы, но вы можете сообщить нам о нарушении" class="b24-form-sign-abuse-help"></span></span> <div><div class="b24-window"><div class="b24-window-overlay" style="display: none;"></div> <div class="b24-window-popup b24-window-popup-p-center" style="display: none;"><div class="b24-window-popup-wrapper"><button type="button" class="b24-window-close" style="z-index: 220;"></button> <div><!----> <div class="b24-window-scrollable" style="z-index: 200;"><div class="b24-window-scroll-anchor" style="display: none;"></div> <div class="b24-window-popup-head"><div class="b24-window-popup-title">Сообщить о нарушении</div></div> <div class="b24-window-popup-body"><div class="b24-form-sign-abuse-popup">
                                                            Компания Битрикс24 не несёт ответственности за содержимое формы, но вы можете сообщить нам о нарушении
                                                        </div></div> <div class="b24-window-scroll-anchor" style="display: none;"></div></div> <!----></div></div></div></div></div></div> <div class="b24-form-sign-info"><span class="b24-form-sign-text">Заряжено</span> <span class="b24-form-sign-bx">Битрикс</span> <span class="b24-form-sign-24">24</span></div></div></div></div></div><script data-b24-form="inline/153/payx0e" data-skip-moving="true" data-b24-loaded="true">
            (function (w, d, u) {
                var s = d.createElement('script');
                s.async = true;
                s.src = u + '?' + (Date.now() / 180000 | 0);
                var h = d.getElementsByTagName('script')[0];
                h.parentNode.insertBefore(s, h);
            })(window, document, 'https://cdn-ru.bitrix24.ru/b9974283/crm/form/loader_153.js');
        </script>
    </div>
@endsection
