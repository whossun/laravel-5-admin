<?php

Route::get('/', function () {
    return '前台首页';
});

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
    Route::resource('users', 'UserController');

    //Roles
    Route::resource('roles', 'RoleController');

    //Permissions
    Route::resource('permissions', 'PermissionController');

    //PermissionGroup
    Route::resource('permissiongroups', 'PermissionGroupController');

    //Articles
    Route::resource('articles', 'ArticleController');

    //Settings
    Route::resource('settings', 'SettingController');

    //Test
    Route::resource('tests', 'TestController');
});

//Api
Route::group(array('prefix' => 'api', 'middleware' => 'allowOrigin'), function () {
    //Users
    Route::resource('users', 'Api\UserController', ['only' => ['index', 'show']]);
});
