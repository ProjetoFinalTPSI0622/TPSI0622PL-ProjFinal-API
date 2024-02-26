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
Route::post( '/auth/forgotPassword', 'AuthenticationController@forgotPassword');
Route::get( '/auth/check', 'AuthenticationController@checkAuth' )->middleware('checkAuth');
Route::get( '/auth/logout', 'AuthenticationController@userLogout' )->middleware('checkAuth');




// -----------------------------------------------------------------USER ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'users', 'middleware' => 'checkAuth'], function() {
    Route::get('/authed' , 'UserController@getAuthedUser');
    Route::put('/changePassword', 'UserController@changePassword');
    Route::put('/resetPassword', 'UserController@resetPassword');
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
    Route::post('/', 'UserInfoController@store');
    Route::put('/{userInfo}', 'UserInfoController@update');
});

// -----------------------------------------------------------------TICKET ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'tickets', 'middleware' => 'checkAuth'], function() {
    Route::get('{ticket}/comments', 'TicketsController@ticketComments');
    Route::put('{ticket}/assign/{technician}', 'TicketsController@assignTechnician');

    Route::put('{ticket}/close', 'TicketsController@closeTicket');
    Route::put('{ticket}/reopen', 'TicketsController@reopenTicket');

    Route::put('{ticket}/status/{status}', 'TicketsController@changeStatus');
    Route::put('{ticket}/priority/{priority}', 'TicketsController@changePriority');

    Route::get('/', 'TicketsController@index');
    Route::post ('/', 'TicketsController@store');
    Route::get('/{ticket}', 'TicketsController@show');
    Route::put('/{ticket}', 'TicketsController@update');
    Route::delete('/{ticket}', 'TicketsController@destroy');
    Route::get('user/{user_id}', 'TicketsController@userTickets');
    Route::get('/tickets/search', 'TicketsController@search');
});


// -----------------------------------------------------------------COMMENT ROUTES-----------------------------------------------------------------

Route::group(['prefix' => 'comments', 'middleware' => 'checkAuth'], function() {
    Route::post('/', 'CommentsController@store');
    Route::delete('/{comment}', 'CommentsController@destroy');
});

// -----------------------------------------------------------------COMMENT TYPE ROUTES-----------------------------------------------------------------

Route::group(['prefix' => 'commentTypes', 'middleware' => 'checkAuth'], function() {
    Route::get('/', 'CommentTypesController@index');
});

// -----------------------------------------------------------------PRIORITY ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'priorities', 'middleware' => 'checkAuth'], function() {
    Route::get('/', 'PrioritiesController@index');
    Route::post('/', 'PrioritiesController@store');
    Route::put('/{id}', 'PrioritiesController@update');
    Route::delete('/{id}', 'PrioritiesController@destroy');
});

// -----------------------------------------------------------------STATUSES ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'statuses', 'middleware' => 'checkAuth'], function() {
    Route::get('/', 'StatusesController@index');
    Route::post('/', 'StatusesController@store');
    Route::put('/{status}', 'StatusesController@update');
    Route::delete('/{status}', 'StatusesController@destroy');
});

// -----------------------------------------------------------------CATEGORIES ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'categories', 'middleware' => 'checkAuth'], function() {
    Route::get('/', 'CategoriesController@index');
    Route::post('/', 'CategoriesController@store');
    Route::put('/{category}', 'CategoriesController@update');
    Route::delete('/{category}', 'CategoriesController@destroy');
});

// -----------------------------------------------------------------LOCATIONS ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'locations', 'middleware' => 'checkAuth'], function() {
    Route::get('/', 'LocationController@index');
    Route::post('/', 'LocationController@store');
    Route::put('/{location}','LocationController@update');
    Route::delete('/{location}', 'LocationController@destroy');
});

// -----------------------------------------------------------------NOTIFICATIONS ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'notifications', 'middleware' => 'checkAuth'], function() {
    Route::get('/check', 'NotificationRecipientController@check');
    Route::get('/', 'NotificationRecipientController@index');
    Route::post('/markAsSeen/{notification}', 'NotificationRecipientController@markAsSeen');
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

Route::get('/status', 'StatusesController@index');

// -----------------------------------------------------------------DASHBOARD ROUTES-----------------------------------------------------------------
Route::group(['prefix' => 'dashboard', 'middleware' => 'checkAuth'], function() {
    Route::get('/ticketsPerDay', 'DashboardController@getTicketsPerDay');
    Route::get('/ticketsPerMonth', 'DashboardController@getTicketsPerMonth');
    Route::get('/getStatsByStatus', 'DashboardController@getStatsByStatus');
    Route::get('/metricByCategories', 'DashboardController@getResolutionTimePerCategory');
    Route::get('/ticketsByCategories', 'DashboardController@getStatsByCategories');
});

//TODO: dont use apiResource and make route groups instead
