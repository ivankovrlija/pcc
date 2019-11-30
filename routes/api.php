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
    Route::apiResource('guests', 'GuestController');
    Route::apiResource('folios', 'FolioController');

    Route::post('folios/{id}', 'FolioController@addGuest');
    Route::post('guests/addfields', 'FieldController@addField');
    Route::get('guests/addfields/{id}', 'FieldController@updateField');

    Route::put('guests/addfields/{id}', 'FieldController@updateFieldName');

    Route::apiResource('guestfoliologs', 'GuestFolioLogController');

    Route::apiResource('me', 'ProfileController');
    Route::apiResource('gettokens', 'ProfileController@getUserTokens');
    Route::post('me/avatar', 'ProfileController@avatar');
    Route::get('me/{id}', 'ProfileController@show');
    
    Route::get('datatable/guests', 'GuestController@datatable');
    Route::get('datatable/folios', 'FolioController@datatable');
    Route::get('getfolioguest/{id}', 'GuestFolioLogController@gueststable');
    Route::get('datatable/folio_guest', 'GuestFolioLogController@datatable');
    
    Route::post('import/guests', 'GuestController@import');
    Route::post('import/folios', 'FolioController@import');

    Route::post('fbtokenadd', 'AuthController@saveFBToken');
    Route::post('fbtokendelete', 'AuthController@removeFbToken');
});

Route::group([ 'middleware' => 'cors' ], function($router) {

    Route::post('checklead', 'LeadController@checklead');
    Route::post('unsubscribe_lead', 'LeadController@unsubscribe');
});

Route::get('export/guests/{id}', 'GuestController@export');
Route::get('export/folios/{id}', 'FolioController@export');
Route::get('export/guests/{id}/{user_id}', 'GuestListController@export');
Route::get('export/folios/{id}/{user_id}', 'GuestFolioListController@export');