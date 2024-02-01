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
Route::get( '/auth/logout', 'AuthenticationController@userLogout' )->middleware('checkAuth');




// -----------------------------------------------------------------USER ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'users', 'middleware' => 'checkAuth'], function() {
    Route::get('/authed' , 'UserController@getAuthedUser');
    Route::put('/changePassword', 'UserController@changePassword');
    Route::get('/technicians', 'UserController@getTechnicians');
    Route::get('/', 'UserController@index');
    Route::post('/', 'UserController@store');
    Route::get('/{user}', 'UserController@show');
    Route::put('/{user}', 'UserController@update');
    Route::delete('/{user}', 'UserController@destroy');
    Route::get('/search', 'UserController@search');
});

// -----------------------------------------------------------------USER_INFO ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'userInfo', 'middleware' => 'checkAuth'], function() {
    Route::get('/', 'UserInfoController@index');
    Route::post('/', 'UserInfoController@store');
    Route::put('/{userInfo}', 'UserInfoController@update');
    Route::delete('/{userInfo}', 'UserInfoController@destroy');
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

// -----------------------------------------------------------------NOTIFICATIONS ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'notifications', 'middleware' => 'checkAuth'], function() {
    Route::get('/check', 'NotificationRecipientController@check');
    Route::get('/', 'NotificationRecipientController@index');
    Route::post('/markAsSeen', 'NotificationRecipientController@markAllAsRead');
    Route::post('/{notification}', 'NotificationRecipientController@show');
});

// -----------------------------------------------------------------ROLES ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'roles', 'middleware' => 'checkAuth'], function() {
    Route::get('/', 'RolesController@index');
});
// -----------------------------------------------------------------GENDER ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'genders', 'middleware' => 'checkAuth'], function() {
    Route::get('/', 'GendersController@index');
});
// -----------------------------------------------------------------COUNTRIES ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'countries', 'middleware' => 'checkAuth'], function() {
    Route::get('/', 'CountriesController@index');
});


// -----------------------------------------------------------------DASHBOARD ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'dashboard', 'middleware' => 'checkAuth'], function() {
    Route::get('/ticketsPerDay', 'DashboardController@getTicketsPerDay');
    Route::get('/getStatsByStatus', 'DashboardController@getStatsByStatus');
});

//TODO: dont use apiResource and make route groups instead

Route::apiResource('gender', 'GendersController');
Route::apiResource('country', 'CountriesController');
Route::apiResource('attachment', 'AttachmentsController');
Route::apiResource('status', 'StatusesController');
Route::apiResource('commentType', 'CommentTypesController');
//Route::apiResource('role', 'RolesController');

Route::apiResource('userInfo', 'UserInfoController');

Route::get('/attachment/attachmentsTicket/{ticket_id}', 'AttachmentsController@attachmentsTicket')->name('attachment.ticket');
