<?php

/*************************
 * Authentication Routes *
**************************/
Route::group([ 'prefix' => 'auth' ], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

    Route::post('oauth/{driver}', 'AuthController@redirectToProvider');
    Route::post('oauth/{driver}/save', 'AuthController@saveToken');
    Route::get('oauth/{driver}/callback', 'AuthController@handleProviderCallback')->name('oauth.callback');
});

/************************************
 * Authentication Restricted Routes *
*************************************/
Route::group([ 'middleware' => 'jwt.auth' ], function($router) {
    Route::get('dashboard', 'DashboardController@index');
    Route::apiResource('courses', 'CourseController');
    Route::get('datatable/courses', 'CourseController@datatable');

    Route::apiResource('me', 'ProfileController');
    Route::apiResource('gettokens', 'ProfileController@getUserTokens');
    Route::post('me/avatar', 'ProfileController@avatar');
    Route::get('me/{id}', 'ProfileController@show');

    Route::post('fbtokenadd', 'AuthController@saveFBToken');
    Route::post('fbtokendelete', 'AuthController@removeFbToken');
});