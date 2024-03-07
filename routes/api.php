<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//TODO ПРАВИЛА ДЛЯ ЛИДА
//ВЫВОД ПРАВИЛ ДЛЯ ЛИДА
Route::get('/leads/rules', [\App\Http\Controllers\Api\Leads\RulesController::class, 'index'])->name('leads.rules.index');
//ДОБАВЛЕНИЕ ПРАВИЛА ДЛЯ ЛИДА
Route::post('/leads/rules', [\App\Http\Controllers\Api\Leads\RulesController::class, 'store'])->name('leads.rules.store');
//ОБНОВЛЕНИЕ ПРАВИЛА ДЛЯ ЛИДА
Route::patch('/leads/rules/{id}', [\App\Http\Controllers\Api\Leads\RulesController::class, 'update'])->name('leads.rules.update');
//ПОЛУЧЕНИЕ ПРАВИЛА ДЛЯ ЛИДА
Route::get('/leads/rules/{id}', [\App\Http\Controllers\Api\Leads\RulesController::class, 'show'])->name('leads.rules.show');
//УДАЛЕНИЕ ПРАВИЛА ДЛЯ ЛИДА
Route::delete('/leads/rules/{id}', [\App\Http\Controllers\Api\Leads\RulesController::class, 'destroy'])->name('leads.rules.destroy');
//ПРОВЕРКА ПРАВИЛ ДЛЯ ЛИДОВ
Route::post('/leads/check_rules', [\App\Http\Controllers\Api\Leads\RulesController::class, 'check_rules'])->name('leads.rules.check_rules');
//

//TODO ПОЛЯ ДЛЯ ЛИДА
//ВЫВОД ПОЛЕЙ ДЛЯ ЛИДА
Route::get('/leads/fields', [\App\Http\Controllers\Api\Leads\FieldsController::class, 'index'])->name('leads.fields.index');
//ДОБАВЛЕНИЕ ПОЛЕЙ ДЛЯ ЛИДА
Route::post('/leads/fields', [\App\Http\Controllers\Api\Leads\FieldsController::class, 'store'])->name('leads.fields.store');
//ОБНОВЛЕНИЕ ПОЛЕЙ ДЛЯ ЛИДА
Route::patch('/leads/fields/{id}', [\App\Http\Controllers\Api\Leads\FieldsController::class, 'update'])->name('leads.fields.update');
//ПОЛУЧЕНИЯ ПОЛЕЙ ДЛЯ ЛИДА
Route::get('/leads/fields/{id}', [\App\Http\Controllers\Api\Leads\FieldsController::class, 'show'])->name('leads.fields.show');
//УДАЛЕНИЕ ПОЛЕЙ ДЛЯ ЛИДА
Route::delete('/leads/fields/{field}', [\App\Http\Controllers\Api\Leads\FieldsController::class, 'destroy'])->name('leads.fields.destroy');
//УДАЛЕНИЕ ПОЛЕЙ ДЛЯ ЛИДА
Route::post('/leads/update_index', [\App\Http\Controllers\Api\Leads\FieldsController::class, 'update_index'])->name('leads.fields.update_index');
//-----------
//----------------
//TODO ЗНАЧЕНИЯ ДЛЯ ЛИДА
//ВЫВОД ЗНАЧЕНИЙ ДЛЯ ЛИДА
Route::get('/leads/values', [\App\Http\Controllers\Api\Leads\ValuesController::class, 'index'])->name('leads.values.index');
//ДОБАВЛЕНИЕ ЗНАЧЕНИЙ ДЛЯ ЛИДА
Route::post('/leads/values', [\App\Http\Controllers\Api\Leads\ValuesController::class, 'store'])->name('leads.values.store');
//ОБНОВЛЕНИЕ ЗНАЧЕНИЙ ДЛЯ ЛИДА
Route::patch('/leads/values/{id}', [\App\Http\Controllers\Api\Leads\ValuesController::class, 'update'])->name('leads.values.update');
//ПОЛУЧЕНИЯ ЗНАЧЕНИЙ ДЛЯ ЛИДА
Route::get('/leads/values/{id}', [\App\Http\Controllers\Api\Leads\ValuesController::class, 'show'])->name('leads.values.show');
//УДАЛЕНИЕ ЗНАЧЕНИЙ ДЛЯ ЛИДА
Route::delete('/leads/values/{field}', [\App\Http\Controllers\Api\Leads\ValuesController::class, 'destroy'])->name('leads.values.destroy');
//-----------
//----------------

//TODO ПРАВИЛА ДЛЯ КОНТАКТА
//ВЫВОД ПРАВИЛ ДЛЯ КОНТАКТА
Route::get('/contacts/rules', [\App\Http\Controllers\Api\Contact\RulesController::class, 'index'])->name('contacts.rules.index');
//ДОБАВЛЕНИЕ ПРАВИЛА ДЛЯ КОНТАКТА
Route::post('/contacts/rules', [\App\Http\Controllers\Api\Contact\RulesController::class, 'store'])->name('contacts.rules.store');
//ОБНОВЛЕНИЕ ПРАВИЛА ДЛЯ КОНТАКТА
Route::patch('/contacts/rules/{id}', [\App\Http\Controllers\Api\Contact\RulesController::class, 'update'])->name('contacts.rules.update');
//ОБНОВЛЕНИЕ ПРАВИЛ БЛОКА ДЛЯ КОНТАКТА
Route::patch('/contacts/rulesblock/{id}', [\App\Http\Controllers\Api\Contact\RulesController::class, 'updateblock'])->name('contacts.rules.updateblock');
//ПОЛУЧЕНИЕ ПРАВИЛА ДЛЯ КОНТАКТА
Route::get('/contacts/rules/{id}', [\App\Http\Controllers\Api\Contact\RulesController::class, 'show'])->name('contacts.rules.show');
//УДАЛЕНИЕ ПРАВИЛА ДЛЯ КОНТАКТА
Route::delete('/contacts/rules/{id}', [\App\Http\Controllers\Api\Contact\RulesController::class, 'destroy'])->name('contacts.rules.destroy');
//УДАЛЕНИЕ БЛОКА ПРАВИЛ ДЛЯ КОНТАКТА
Route::delete('/contacts/rulesblock/{id}', [\App\Http\Controllers\Api\Contact\RulesController::class, 'destroyblock'])->name('contacts.rules.destroyblock');
//ПРОВЕРКА ПРАВИЛ ДЛЯ КОНТАКТА
Route::post('/contacts/check_rules', [\App\Http\Controllers\Api\Contact\RulesController::class, 'check_rules'])->name('contacts.rules.check_rules');
//
//TODO ПОЛЯ ДЛЯ КОНТАКТА
//ВЫВОД ПОЛЕЙ ДЛЯ КОНТАКТА
Route::get('/contacts/fields', [\App\Http\Controllers\Api\Contact\FieldsController::class, 'index'])->name('contacts.fields.index');
//ДОБАВЛЕНИЕ ПОЛЕЙ ДЛЯ КОНТАКТА
Route::post('/contacts/fields', [\App\Http\Controllers\Api\Contact\FieldsController::class, 'store'])->name('contacts.fields.store');
//ОБНОВЛЕНИЕ ПОЛЕЙ ДЛЯ КОНТАКТА
Route::patch('/contacts/fields/{id}', [\App\Http\Controllers\Api\Contact\FieldsController::class, 'update'])->name('contacts.fields.update');
//ПОЛУЧЕНИЯ ПОЛЕЙ ДЛЯ КОНТАКТА
Route::get('/contacts/fields/{id}', [\App\Http\Controllers\Api\Contact\FieldsController::class, 'show'])->name('contacts.fields.show');
//УДАЛЕНИЕ ПОЛЕЙ ДЛЯ КОНТАКТА
Route::delete('/contacts/fields/{field}', [\App\Http\Controllers\Api\Contact\FieldsController::class, 'destroy'])->name('contacts.fields.destroy');
//УДАЛЕНИЕ ПОЛЕЙ ДЛЯ КОНТАКТА
Route::post('/contacts/update_index', [\App\Http\Controllers\Api\Contact\FieldsController::class, 'update_index'])->name('contacts.fields.update_index');
//-----------
//----------------

//TODO ПРАВИЛА ДЛЯ КОМПАНИИ
//ВЫВОД ПРАВИЛ ДЛЯ КОМПАНИИ
Route::get('/company/rules', [\App\Http\Controllers\Api\Company\RulesController::class, 'index'])->name('company.rules.index');
//ДОБАВЛЕНИЕ ПРАВИЛА ДЛЯ КОМПАНИИ
Route::post('/company/rules', [\App\Http\Controllers\Api\Company\RulesController::class, 'store'])->name('company.rules.store');
//ОБНОВЛЕНИЕ ПРАВИЛА ДЛЯ КОМПАНИИ
Route::patch('/company/rules/{id}', [\App\Http\Controllers\Api\Company\RulesController::class, 'update'])->name('company.rules.update');
//ПОЛУЧЕНИЕ ПРАВИЛА ДЛЯ КОМПАНИИ
Route::get('/company/rules/{id}', [\App\Http\Controllers\Api\Company\RulesController::class, 'show'])->name('company.rules.show');
//УДАЛЕНИЕ ПРАВИЛА ДЛЯ КОМПАНИИ
Route::delete('/company/rules/{id}', [\App\Http\Controllers\Api\Company\RulesController::class, 'destroy'])->name('company.rules.destroy');
//ПРОВЕРКА ПРАВИЛ ДЛЯ КОМПАНИИ
Route::post('/company/check_rules', [\App\Http\Controllers\Api\Company\RulesController::class, 'check_rules'])->name('company.rules.check_rules');
//
//TODO ПОЛЯ ДЛЯ КОМПАНИИ
//ВЫВОД ПОЛЕЙ ДЛЯ КОМПАНИИ
Route::get('/company/fields', [\App\Http\Controllers\Api\Company\FieldsController::class, 'index'])->name('company.fields.index');
//ДОБАВЛЕНИЕ ПОЛЕЙ ДЛЯ КОМПАНИИ
Route::post('/company/fields', [\App\Http\Controllers\Api\Company\FieldsController::class, 'store'])->name('company.fields.store');
//ОБНОВЛЕНИЕ ПОЛЕЙ ДЛЯ КОМПАНИИ
Route::patch('/company/fields/{id}', [\App\Http\Controllers\Api\Company\FieldsController::class, 'update'])->name('company.fields.update');
//ПОЛУЧЕНИЯ ПОЛЕЙ ДЛЯ КОМПАНИИ
Route::get('/company/fields/{id}', [\App\Http\Controllers\Api\Company\FieldsController::class, 'show'])->name('company.fields.show');
//УДАЛЕНИЕ ПОЛЕЙ ДЛЯ КОМПАНИИ
Route::delete('/company/fields/{field}', [\App\Http\Controllers\Api\Company\FieldsController::class, 'destroy'])->name('company.fields.destroy');
//УДАЛЕНИЕ ПОЛЕЙ ДЛЯ КОМПАНИИ
Route::post('/company/update_index', [\App\Http\Controllers\Api\Company\FieldsController::class, 'update_index'])->name('company.fields.update_index');
//-----------
//----------------

//TODO ПРАВИЛА ДЛЯ СДЕЛКИ
//ВЫВОД ПРАВИЛ ДЛЯ СДЕЛКИ
Route::get('/deal/rules', [\App\Http\Controllers\Api\Deal\RulesController::class, 'index'])->name('deal.rules.index');
//ДОБАВЛЕНИЕ ПРАВИЛА ДЛЯ СДЕЛКИ
Route::post('/deal/rules', [\App\Http\Controllers\Api\Deal\RulesController::class, 'store'])->name('deal.rules.store');
//ОБНОВЛЕНИЕ ПРАВИЛА ДЛЯ СДЕЛКИ
Route::patch('/deal/rules/{id}', [\App\Http\Controllers\Api\Deal\RulesController::class, 'update'])->name('deal.rules.update');
//ПОЛУЧЕНИЕ ПРАВИЛА ДЛЯ СДЕЛКИ
Route::get('/deal/rules/{id}', [\App\Http\Controllers\Api\Deal\RulesController::class, 'show'])->name('deal.rules.show');
//УДАЛЕНИЕ ПРАВИЛА ДЛЯ СДЕЛКИ
Route::delete('/deal/rules/{id}', [\App\Http\Controllers\Api\Deal\RulesController::class, 'destroy'])->name('deal.rules.destroy');
//ПРОВЕРКА ПРАВИЛ ДЛЯ СДЕЛКИ
Route::post('/deal/check_rules', [\App\Http\Controllers\Api\Deal\RulesController::class, 'check_rules'])->name('deal.rules.check_rules');
//
//TODO ПОЛЯ ДЛЯ СДЕЛКИ
//ВЫВОД ПОЛЕЙ ДЛЯ СДЕЛКИ
Route::get('/deal/fields', [\App\Http\Controllers\Api\Deal\FieldsController::class, 'index'])->name('deal.fields.index');
//ДОБАВЛЕНИЕ ПОЛЕЙ ДЛЯ СДЕЛКИ
Route::post('/deal/fields', [\App\Http\Controllers\Api\Deal\FieldsController::class, 'store'])->name('deal.fields.store');
//ОБНОВЛЕНИЕ ПОЛЕЙ ДЛЯ СДЕЛКИ
Route::patch('/deal/fields/{id}', [\App\Http\Controllers\Api\Deal\FieldsController::class, 'update'])->name('deal.fields.update');
//ПОЛУЧЕНИЯ ПОЛЕЙ ДЛЯ СДЕЛКИ
Route::get('/deal/fields/{id}', [\App\Http\Controllers\Api\Deal\FieldsController::class, 'show'])->name('deal.fields.show');
//УДАЛЕНИЕ ПОЛЕЙ ДЛЯ СДЕЛКИ
Route::delete('/deal/fields/{field}', [\App\Http\Controllers\Api\Deal\FieldsController::class, 'destroy'])->name('deal.fields.destroy');
//УДАЛЕНИЕ ПОЛЕЙ ДЛЯ СДЕЛКИ
Route::post('/deal/update_index', [\App\Http\Controllers\Api\Deal\FieldsController::class, 'update_index'])->name('deal.fields.update_index');
//-----------
//----------------

//TODO ПРАВИЛА ДЛЯ ПРЕДЛОЖЕНИЯ
//ВЫВОД ПРАВИЛ ДЛЯ ПРЕДЛОЖЕНИЯ
Route::get('/quote/rules', [\App\Http\Controllers\Api\Quote\RulesController::class, 'index'])->name('quote.rules.index');
//ДОБАВЛЕНИЕ ПРАВИЛА ДЛЯ ПРЕДЛОЖЕНИЯ
Route::post('/quote/rules', [\App\Http\Controllers\Api\Quote\RulesController::class, 'store'])->name('quote.rules.store');
//ОБНОВЛЕНИЕ ПРАВИЛА ДЛЯ ПРЕДЛОЖЕНИЯ
Route::patch('/quote/rules/{id}', [\App\Http\Controllers\Api\Quote\RulesController::class, 'update'])->name('quote.rules.update');
//ПОЛУЧЕНИЕ ПРАВИЛА ДЛЯ ПРЕДЛОЖЕНИЯ
Route::get('/quote/rules/{id}', [\App\Http\Controllers\Api\Quote\RulesController::class, 'show'])->name('quote.rules.show');
//УДАЛЕНИЕ ПРАВИЛА ДЛЯ ПРЕДЛОЖЕНИЯ
Route::delete('/quote/rules/{id}', [\App\Http\Controllers\Api\Quote\RulesController::class, 'destroy'])->name('quote.rules.destroy');
//ПРОВЕРКА ПРАВИЛ ДЛЯ ПРЕДЛОЖЕНИЯ
Route::post('/quote/check_rules', [\App\Http\Controllers\Api\Quote\RulesController::class, 'check_rules'])->name('quote.rules.check_rules');
//
//TODO ПОЛЯ ДЛЯ ПРЕДЛОЖЕНИЯ
//ВЫВОД ПОЛЕЙ ДЛЯ ПРЕДЛОЖЕНИЯ
Route::get('/quote/fields', [\App\Http\Controllers\Api\Quote\FieldsController::class, 'index'])->name('quote.fields.index');
//ДОБАВЛЕНИЕ ПОЛЕЙ ДЛЯ ПРЕДЛОЖЕНИЯ
Route::post('/quote/fields', [\App\Http\Controllers\Api\Quote\FieldsController::class, 'store'])->name('quote.fields.store');
//ОБНОВЛЕНИЕ ПОЛЕЙ ДЛЯ ПРЕДЛОЖЕНИЯ
Route::patch('/quote/fields/{id}', [\App\Http\Controllers\Api\Quote\FieldsController::class, 'update'])->name('quote.fields.update');
//ПОЛУЧЕНИЯ ПОЛЕЙ ДЛЯ ПРЕДЛОЖЕНИЯ
Route::get('/quote/fields/{id}', [\App\Http\Controllers\Api\Quote\FieldsController::class, 'show'])->name('quote.fields.show');
//УДАЛЕНИЕ ПОЛЕЙ ДЛЯ ПРЕДЛОЖЕНИЯ
Route::delete('/quote/fields/{field}', [\App\Http\Controllers\Api\Quote\FieldsController::class, 'destroy'])->name('quote.fields.destroy');
//УДАЛЕНИЕ ПОЛЕЙ ДЛЯ ПРЕДЛОЖЕНИЯ
Route::post('/quote/update_index', [\App\Http\Controllers\Api\Quote\FieldsController::class, 'update_index'])->name('quote.fields.update_index');
//-----------
//----------------

////TODO ЗАВИСИМОСТИ СПИСКОВ ДЛЯ ЛИДА
//ВЫВОД ПОЛЕЙ ДЛЯ ЛИДА
Route::get('/leads/dependency', [\App\Http\Controllers\Api\Leads\DependencyController::class, 'index'])->name('leads.fields.dependency.index');
//ДОБАВЛЕНИЕ ПОЛЕЙ ДЛЯ ЛИДА
Route::post('/leads/dependency', [\App\Http\Controllers\Api\Leads\DependencyController::class, 'store'])->name('leads.fields.dependency.store');
//ОБНОВЛЕНИЕ ПОЛЕЙ ДЛЯ ЛИДА
Route::patch('/leads/dependency/{id}', [\App\Http\Controllers\Api\Leads\DependencyController::class, 'update'])->name('leads.fields.dependency.update');
//ПОЛУЧЕНИЯ ПОЛЕЙ ДЛЯ ЛИДА
Route::get('/leads/dependency/{id}', [\App\Http\Controllers\Api\Leads\DependencyController::class, 'show'])->name('leads.fields.dependency.show');
//УДАЛЕНИЕ ПОЛЕЙ ДЛЯ ЛИДА
Route::delete('/leads/dependency/{field}', [\App\Http\Controllers\Api\Leads\DependencyController::class, 'destroy'])->name('leads.fields.dependency.destroy');
//ВЫВОД ПОЛЕЙ ДЛЯ ЗНАЧЕНИЯ ИЗ СПИСКА
Route::get('/leads/dependency/list/{id}', [\App\Http\Controllers\Api\Leads\DependencyController::class, 'list'])->name('leads.fields.dependency.list');

//-----------
//TODO ПОМОШНИКИ
//ПРАВИЛ ДЛЯ ПОЛЕЙ
Route::get('/help/rules_fields', [\App\Http\Controllers\Api\Help\HelpController::class, 'rules_fields'])->name('help.rules_fields');
//ТИПЫ ПОЛЕЙ
Route::get('/help/type_fields', [\App\Http\Controllers\Api\Help\HelpController::class, 'type_fields'])->name('help.type_fields');
//ТИПЫ ПОЛЕЙ
Route::get('/help/rule_type', [\App\Http\Controllers\Api\Help\HelpController::class, 'rule_type'])->name('help.rule_type');




Route::get('/qwe', [\App\Http\Controllers\Api\LeadsController::class, 'test'])->name('test.leads');

Route::post('/rules', [\App\Http\Controllers\Api\LeadsController::class, 'rules'])->name('rules.leads');
//ДОБАВЛЕНИЕ ПРАВИЛА ДЛЯ ЛИДА
Route::post('/addrules/leads/{type}', [\App\Http\Controllers\Api\LeadsController::class, 'addrules'])->name('addrules.leads');
//ОБНОВЛЕНИЕ ПРАВИЛА ДЛЯ ЛИДА
Route::post('/updrules/leads/{type}', [\App\Http\Controllers\Api\LeadsController::class, 'addrules'])->name('addrules.leads');
//ДОБАВЛЕНИЕ ПОЛЯ ДЛЯ ЛИДА
Route::post('/leads/addfield', [\App\Http\Controllers\Api\LeadsController::class, 'addfield'])->name('addfield.leads');
//ОБНОВЛЕНИЕ ПОЛЯ ДЛЯ ЛИДА
Route::post('/leads/updfield/{id}', [\App\Http\Controllers\Api\LeadsController::class, 'updfield'])->name('updfield.leads');
//УДАЛЕНИЕ ПОЛЯ ДЛЯ ЛИДА
Route::post('/leads/delfield/{id}', [\App\Http\Controllers\Api\LeadsController::class, 'delfield'])->name('delfield.leads');
