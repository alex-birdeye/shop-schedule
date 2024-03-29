<?php

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('is-opened', [ScheduleController::class, 'isOpened']);
Route::get('will-open', [ScheduleController::class, 'willOpen']);

Route::get('settings', [SettingsController::class, 'index']);
Route::post('settings', [SettingsController::class, 'store']);
