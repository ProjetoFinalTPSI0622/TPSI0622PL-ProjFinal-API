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


Route::group([ 'prefix' => 'auth', 'middleware' => 'api' ], function () {
    Route::post( '/login', 'AuthenticationController@userLogin' )->name( 'auth.login' );
    Route::get( '/check', 'AuthenticationController@checkAuth' )->name( 'auth.check' );
    //Route::post( '/logout', 'AuthenticationController@logout' )->name( 'auth.logout' ); not implemented yet
} );



Route::group(['prefix' => 'user', 'middleware' => 'api'], function() {
    Route::get('/', 'UserController@index')->name('user.index');
    Route::post('/users', 'UserController@store')->name('user.store');
    Route::put('/{id}', 'UserController@update')->name('user.update');
    Route::delete('/{id}', 'UserController@destroy')->name('user.destroy');
    Route::get('/search', 'UserController@search')->name('user.search');
});
//Todos os tickets do user loggado
Route::get('/userTickets', 'TicketsController@userTickets')->middleware('auth:api')->name('tickets.userTickets');
//Search tickets por nome
Route::get('/tickets/search', 'TicketsController@search')->middleware('auth:api')->name('tickets.search');
Route::post('/tickets', 'TicketsController@store')->middleware('auth:api')->name('tickets.store');

Route::group(['prefix' => '/tickets', 'middleware' => 'api'], function() {
    Route::get('/', 'TicketsController@index')->name('tickets.index');
    Route::get('/{ticket}', 'TicketsController@show')->name('tickets.show');
    Route::put('/{ticket}', 'TicketsController@update')->name('tickets.update');
    Route::delete('/{ticket}', 'TicketsController@destroy')->name('tickets.destroy');

});


Route::apiResource( 'tickets', 'TicketsController' );
Route::apiResource('gender', 'GendersController');
Route::apiResource('country', 'CountriesController');
Route::apiResource('attachment', 'AttachmentsController');
Route::apiResource('status', 'StatusesController');
Route::apiResource('priority', 'PrioritiesController');
Route::apiResource('category', 'CategoriesController');
Route::apiResource('commentType', 'CommentTypesController');
Route::apiResource('role', 'RolesController');

Route::apiResource('userInfo', 'UserInfoController');

Route::get('/attachment/attachmentsTicket/{ticket_id}', 'AttachmentsController@attachmentsTicket')->name('attachment.ticket');
