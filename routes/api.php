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
Route::post('images/create','ImagesController@create')->name('createImage');
Route::get('images/get/course/{idCourse}','ImagesController@get')->name('getImagesCourse');
Route::get('images/get/user/{idUser}','ImagesController@getImageUser')->name('getImagesUser');
Route::get('images/get/user_course/{idCourse}/{userId}','ImagesController@getCourseUser')->name('getCourseUser');
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
