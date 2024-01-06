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

Route::group([ 'prefix' => 'auth' ], function () {
    Route::post( '/login', 'AuthenticationController@userLogin' )->name( 'auth.login' );
    Route::get( '/check', 'AuthenticationController@checkAuth' )->name( 'auth.check' );
    //Route::post( '/logout', 'AuthenticationController@logout' )->name( 'auth.logout' ); not implemented yet
} );


Route::post('/user', 'UserController@store')->name('user.store');

Route::group(['prefix' => 'user'], function() {
    Route::get('/', 'UserController@index')->middleware('auth:api')->name('user.index');
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

