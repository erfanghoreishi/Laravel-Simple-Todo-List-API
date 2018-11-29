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

Route::middleware(['auth:api', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});

//register
Route::post('Auth/register', 'api\Auth\RegisterController@register')->name('register');



Route::middleware(['auth:api', 'verified'])->group(function () {

    //sms verification
    Route::get('sms/verify/{code}', 'api\Auth\SMSVerificationController@verify')->middleware('throttle:6,1')->name('sms.verification.verify');
    Route::get('sms/resend', 'api\Auth\SMSVerificationController@resend')->middleware('throttle:32,1')->name('sms.verification.resend');


    //todoes
    Route::apiResource('todos', 'api\TodoController');

    //task
    Route::apiResource('tasks', 'api\TaskController')->except(['store']);
    Route::post('/todos/{todo}/tasks', 'api\TaskController@store')->middleware(['auth:api', 'verified'])->name('tasks.store');


});


//admin
Route::get('/users', 'api\AdminController@index')->name('users.index')->middleware(['auth:admin']);
Route::post('/users/{user}', 'api\AdminController@verify')->name('users.verify')->middleware(['auth:admin']);

