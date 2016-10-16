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

/**
 * Since we're using Dingo API for the moment. We have to use the dingo router and register routes like below
 *
 * @var \Dingo\Api\Routing\Router
 */
$api = api_router();

$api->version('v1', function ($api) {

    $api->group([
        'namespace' => 'App\Http\Controllers\V1\Pub',
        'prefix' => '/', // public api has no prefix
        'protected' => false,
    ], function ($api) {

        $api->group([
            'namespace' => 'Calendar\Entries',
            'prefix' => 'calendar/entries',
            'protected' => false,
            'middleware' => []], function ($api) {

            $api->get('/', [
                'as' => 'public.calendar.entries.index',
                'uses' => 'CalenderEntryController@index',
            ]);

        }); // end of Calendar\Entries

    }); // end of public v1

    $api->group([
        'namespace' => 'App\Http\Controllers\V1\Management',
        'prefix' => 'mgmt',
        'protected' => false,
    ], function ($api) {

        $api->group([
            'namespace' => 'Calendar\Entries',
            'prefix' => 'calendar/entries',
            'protected' => false,
            'middleware' => []], function ($api) {

            $api->get('/', [
                'as' => 'mgmt.calendar.entries.index',
                'uses' => 'CalenderEntryController@index',
            ]);

            $api->get('/{id}', [
                'as' => 'mgmt.calendar.entries.show',
                'uses' => 'CalenderEntryController@show',
            ]);

            $api->post('/', [
                'as' => 'mgmt.calendar.entries.store',
                'uses' => 'CalenderEntryController@store',
            ]);

            $api->put('/{id}', [
                'as' => 'mgmt.calendar.entries.update',
                'uses' => 'CalenderEntryController@update',
            ]);

            $api->delete('/{id}', [
                'as' => 'mgmt.calendar.entries.delete',
                'uses' => 'CalenderEntryController@destroy',
            ]);

        }); // end of Calendar\Entries

    }); // end of App\Http\Controllers\V1

}); // end of mgmt v1

// TODO - TO delete: old laravel routes below
/*
Route::get('/calender/entries/{id}' , "EntryController@show");
Route::get('/calender/entries' , "EntryController@index");
Route::post('/calender/entries' , "EntryController@create");
Route::patch('/calender/entries' , "EntryController@update");
Route::delete('/calender/entries/{id}' , "EntryController@delete");
*/