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
Route::group(['prefix' => 'user'], function() {
    Route::get('/', 'UserController@index')->middleware('auth:api')->name('user.index');
    Route::post('/', 'UserController@store')->middleware('auth:api')->name('user.store');
    Route::put('/{id}', 'UserController@update')->middleware('auth:api')->name('user.update');
    Route::delete('/{id}', 'UserController@destroy')->middleware('auth:api')->name('user.destroy');
    Route::get('/search', 'UserController@search')->middleware('auth:api')->name('user.search');

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

