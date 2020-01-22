<?php

use Illuminate\Http\Request;

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

// Create Task Route
Route::post('/task/submit', 'TasksController@createTask');

Route::get('/task/{tech_id}/{task_idd}', 'TasksController@getTaskDesc');

Route::get('/task/{tech_idd}', 'TasksController@getList');

Route::put('/task/{task_idd}', 'TasksController@updateStatus');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
