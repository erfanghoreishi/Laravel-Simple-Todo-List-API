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
Route::post('Auth/register', 'api\Auth\RegisterController@register');

//email Verification
Route::get('email/verify/{id}', 'api\Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'api\Auth\VerificationController@resend')->name('verification.resend');
//------------------------

//todoes
Route::apiResource('todos', 'api\TodoController')->middleware(['auth:api', 'verified']);

//task
Route::apiResource('tasks', 'api\TaskController')->middleware(['auth:api', 'verified'])->except(['store']);
Route::post('/todos/{todo}/tasks', 'api\TaskController@store')->middleware(['auth:api', 'verified'])->name('tasks.store');
