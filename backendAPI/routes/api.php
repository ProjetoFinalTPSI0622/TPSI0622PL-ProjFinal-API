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
Route::put('user/login', 'UserController@userLogin'); //login doesnt go trough auth guard
Route::post('/user', 'UserController@store')->name('user.store');

Route::group(['prefix' => 'user'], function() {
    Route::get('/', 'UserController@index')->middleware('auth:api')->name('user.index');
    Route::put('/{id}', 'UserController@update')->middleware('auth:api')->name('user.update');
    Route::delete('/{id}', 'UserController@destroy')->middleware('auth:api')->name('user.destroy');
    Route::get('/search', 'UserController@search')->middleware('auth:api')->name('user.search');

});
//Todos os tickets do user loggado
Route::get('/userTickets', 'TicketsController@userTickets')->middleware('auth:api')->name('tickets.userTickets');
//Search tickets por nome
Route::get('/tickets/search', 'TicketsController@search')->middleware('auth:api')->name('tickets.search');
Route::post('/tickets', 'TicketsController@store')->middleware('auth:api')->name('tickets.store');

Route::group(['prefix' => '/tickets'], function() {
    Route::get('/', 'TicketsController@index')->middleware('auth:api')->name('tickets.index');
    Route::get('/{ticket}', 'TicketsController@show')->middleware('auth:api')->name('tickets.show');
    Route::put('/{ticket}', 'TicketsController@update')->middleware('auth:api')->name('tickets.update');
    Route::delete('/{ticket}', 'TicketsController@destroy')->middleware('auth:api')->name('tickets.destroy');

});

Route::apiResource('gender', 'GendersController');
Route::apiResource('country', 'CountriesController');
Route::apiResource('attachment', 'AttachmentsController');
Route::apiResource('status', 'StatusesController');
Route::apiResource('priority', 'PrioritiesController');
Route::apiResource('category', 'CategoriesController');
Route::apiResource('commentType', 'CommentTypesController');
Route::apiResource('role', 'RolesController');

