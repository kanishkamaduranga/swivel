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

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function () {

    Route::post('/search', 'SearchController@index')->name('search');

    Route::get('/main', 'SearchController@main')->name('main.list');

    Route::get('/ticket', 'TicketController@index')->name('ticket.list');
    Route::get('/user', 'UserController@index')->name('user.list');
    Route::get('/organization', 'OrganizationController@index')->name('organization.list');

});

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
