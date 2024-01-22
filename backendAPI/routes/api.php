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


Route::post( '/auth/login', 'AuthenticationController@userLogin');
Route::get( '/auth/check', 'AuthenticationController@checkAuth' )->middleware('checkAuth');


// -----------------------------------------------------------------USER ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'users', 'middleware' => 'checkAuth'], function() {
    Route::get('/', 'UserController@index');
    Route::post('/', 'UserController@store');
    Route::put('/{id}', 'UserController@update');
    Route::delete('/{id}', 'UserController@destroy');
    Route::get('/search', 'UserController@search');
    Route::get('/authed' , 'UserController@getAuthedUser');
});


// -----------------------------------------------------------------TICKET ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'tickets', 'middleware' => 'checkAuth'], function() {
    Route::get('/', 'TicketsController@index');
    Route::post ('/', 'TicketsController@store');
    Route::get('/{ticket}', 'TicketsController@show');
    Route::put('/{ticket}', 'TicketsController@update');
    Route::delete('/{ticket}', 'TicketsController@destroy');
    Route::get('user/{user_id}', 'TicketsController@userTickets');
    Route::get('/tickets/search', 'TicketsController@search');
});

// -----------------------------------------------------------------PRIORITY ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'priorities', 'middleware' => 'checkAuth'], function() {
    Route::get('/', 'PrioritiesController@index');
    Route::post('/', 'PrioritiesController@store');
    Route::delete('/{id}', 'PrioritiesController@destroy');
});

// -----------------------------------------------------------------CATEGORY ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'categories', 'middleware' => 'checkAuth'], function() {
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

Route::apiResource('userInfo', 'UserInfoController');

Route::get('/attachment/attachmentsTicket/{ticket_id}', 'AttachmentsController@attachmentsTicket')->name('attachment.ticket');
