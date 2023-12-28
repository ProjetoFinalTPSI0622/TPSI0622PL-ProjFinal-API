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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/users/search', 'UserController@search')->name('users.search');
Route::apiResource('users', 'UserController');

Route::apiResource('gender', 'GendersController');
Route::apiResource('country', 'CountriesController');
Route::apiResource('attachment', 'AttachmentsController');
Route::apiResource('status', 'StatusesController');
Route::apiResource('priority', 'PrioritiesController');
Route::apiResource('category', 'CategoriesController');
Route::apiResource('commentType', 'CommentTypesController');
Route::apiResource('role', 'RolesController');

