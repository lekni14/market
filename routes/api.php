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
// Route::post('/user',[
// 	'user' => 'UsersController@signup'
// ]);
Route::post('/signup', 'UserController@signup');
Route::post('/signin', 'UserController@signin');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

