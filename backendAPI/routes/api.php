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


// -----------------------------------------------------------------USER ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'users', 'middleware' => 'api'], function() {
    Route::get('/', 'UserController@index');
    Route::post('/', 'UserController@store');
    Route::put('/{id}', 'UserController@update');
    Route::delete('/{id}', 'UserController@destroy');
    Route::get('/search', 'UserController@search');
});


// -----------------------------------------------------------------TICKET ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'tickets', 'middleware' => 'api'], function() {
    Route::get('/', 'TicketsController@index');
    Route::post ('/', 'TicketsController@store');
    Route::get('/{ticket}', 'TicketsController@show');
    Route::put('/{ticket}', 'TicketsController@update');
    Route::delete('/{ticket}', 'TicketsController@destroy');
    Route::get('user/{user_id}', 'TicketsController@userTickets');
    Route::get('/tickets/search', 'TicketsController@search');
});

// -----------------------------------------------------------------PRIORITY ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'priorities', 'middleware' => 'api'], function() {
    Route::get('/', 'PrioritiesController@index');
    Route::post('/', 'PrioritiesController@store');
    Route::delete('/{id}', 'PrioritiesController@destroy');
});

// -----------------------------------------------------------------CATEGORY ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'categories', 'middleware' => 'api'], function() {
    Route::get('/', 'CategoriesController@index');
    Route::post('/', 'CategoriesController@store');
    Route::delete('/{id}', 'CategoriesController@destroy');
});


//TODO: dont use apiResource and make route groups instead

Route::apiResource('gender', 'GendersController');
Route::apiResource('country', 'CountriesController');
Route::apiResource('attachment', 'AttachmentsController');
Route::apiResource('status', 'StatusesController');
Route::apiResource('commentType', 'CommentTypesController');
Route::apiResource('role', 'RolesController');

Route::get('/attachment/attachmentsTicket/{ticket_id}', 'AttachmentsController@attachmentsTicket')->name('attachment.ticket');
