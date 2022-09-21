<?php

use App\Http\Controllers\Quiz\Question\Alternative\AlternativeController;
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

Route::group(['namespace' => 'Quiz\Question\Alternative'], function () {
    Route::post('/questions/{question}/alternatives', [AlternativeController::class, 'create']);
});
