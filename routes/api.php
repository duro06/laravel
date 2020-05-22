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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function() {
    Route::group(['middleware'=>'auth:sanctum'], function(){
        Route::post('logout', 'Auth\AuthController@logout');
    });

    Route::post('register', 'Auth\AuthController@register'); // ini untuk alamat api/auth/register
    Route::post('login', 'Auth\AuthController@login');

});

Route::group(['prefix'=>'user'], function(){
    Route::group(['middleware'=>'auth:sanctum'], function(){
        Route::get('/', 'Auth\AuthController@getUser');
        Route::put('update-profile/{user}', 'Auth\AuthController@update_profile');
        Route::put('update-image/{user}', 'Auth\AuthController@update_image');
        Route::post('link-to-member', 'Auth\AuthController@link_with_member');
        Route::post('unlink-to-member', 'Auth\AuthController@unlink_with_member');

    });
});

Route::group(['prefix'=>'member'], function(){
    Route::group(['middleware' => 'auth:sanctum'], function (){
        Route::get('anggota', 'Members\MemberController@getMembers');
        Route::get('memberById', 'Members\MemberController@getMemberById');
        Route::post('tambah', 'Members\MemberController@store');
        Route::post('update-status', 'Members\MemberController@update_status');
        Route::put('update-image/{member}', 'Members\MemberController@update_image');
        Route::put('update-profile/{member}', 'Members\MemberController@update_profile');
    });
});
