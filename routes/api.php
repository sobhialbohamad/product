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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register','Authcontroller@register');
Route::post('/login','Authcontroller@login');



//Route::post('/update/{id}','ProductController@update');
Route::post('/destroy/{id}','ProductController@destroy');
 Route::middleware('auth:api')->group(function(){
Route::get('/index/','ProductController@index');

Route::post('/store','ProductController@store');
Route::get('/show/{id}','ProductController@show');
Route::get('/search/{type}/{name}','ProductController@search');
Route::post('/comment/{id}','CommentController@store');
Route::put('/update/{id}','ProductController@update');
Route::post('/like/{id}','LikeController@store');
// /
});
