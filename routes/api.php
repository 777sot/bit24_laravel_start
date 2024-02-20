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


//TODO ПРАВИЛА ДЛЯ ЛИДА НЕ РЕАЛИЗОВАНО!!!!!!!!!!НЕ РЕАЛИЗОВАНО!!!!!!!!!!НЕ РЕАЛИЗОВАНО!!!!!!!!!!НЕ РЕАЛИЗОВАНО!!!!!!!!!!
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
//-----------НЕ РЕАЛИЗОВАНО!!!!!!!!!!НЕ РЕАЛИЗОВАНО!!!!!!!!!!НЕ РЕАЛИЗОВАНО!!!!!!!!!!

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
//-----------
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




Route::post('/test', [\App\Http\Controllers\Api\LeadsController::class, 'test'])->name('test.leads');

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
