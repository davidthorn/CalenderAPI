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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::get('/calender/entries/{id}' , "EntryController@entry");
Route::get('/calender/entries' , "EntryController@entries");
Route::post('/calender/entries' , "EntryController@create");
Route::patch('/calender/entries' , "EntryController@update");
Route::delete('/calender/entries' , "EntryController@delete");