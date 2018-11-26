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

Route::middleware(['auth:api', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});


//

//public emailVerification
Route::get('email/verify/{id}', 'api\Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'api\Auth\VerificationController@resend')->name('verification.resend');
//------------------------


//login
//$this->post('login', 'Auth\LoginController@login');
//$this->post('logout', 'Auth\LoginController@logout')->name('logout');


//register
Route::post('Auth/register', 'api\Auth\RegisterController@register');