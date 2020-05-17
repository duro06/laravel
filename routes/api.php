<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function() {

    Route::post('register', 'Auth\AuthController@register'); // ini untuk alamat api/auth/register
    Route::post('login', 'Auth\AuthController@login');
    Route::post('logout', 'Auth\AuthController@logout')->middleware('auth:sanctum');

    
    // Route::post('addtoreg', 'RegistrationController@addtoreg'); // ini alamat untuk user selain root dan admin (api/auth/addtoreg)

    // Route::group(['middleware' => 'auth:sanctum'], function () {
    //     Route::get('logout', 'AuthController@logout');
    //     Route::get('profile', 'AuthController@profile');
    // });
});

Route::group(['prefix'=>'member'], function(){
    Route::group(['middleware' => 'auth:sanctum'], function (){
        Route::get('anggota', 'Members\MemberController@getMembers');
        Route::get('memberById', 'Members\MemberController@getMemberById');
        Route::post('tambah', 'Members\MemberController@store');
        Route::post('update', 'Members\MemberController@update');
    });
});
