<?php

//Login
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

//Admin
Route::group(array('prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'), function () {

    //Dashboard
    Route::get('/', array('as' => 'admin.dashboard.index', 'uses' => 'DashboardController@index'));

    //Users
    Route::resource('users', 'UsersController');

    //Roles
    Route::resource('roles', 'RolesController');

    //Permissions
    Route::resource('permissions', 'PermissionsController');

    //Articles
    Route::resource('articles', 'ArticlesController');

    //Settings
    Route::resource('settings', 'SettingsController');

});

//Api
Route::group(array('prefix' => 'api', 'middleware' => 'allowOrigin'), function () {
    //Users
    Route::resource('users', 'Api\UsersController', ['only' => ['index', 'show']]);
});
