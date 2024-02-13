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


Route::post('/rules', [\App\Http\Controllers\Api\LeadsController::class, 'rules']);
Route::post('/addrules/leads/{type}', [\App\Http\Controllers\Api\LeadsController::class, 'addrules'])->name('addrules.leads');
