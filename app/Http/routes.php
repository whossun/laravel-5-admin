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
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {

    //Dashboard
    Route::get('/', ['as' => 'admin.dashboard.index', 'uses' => 'DashboardController@index']);

    //Users
    Route::resource('users', 'UserController');

    //Roles
    Route::resource('roles', 'RoleController');

    //Permissions
    Route::resource('permissions', 'PermissionController');
    Route::post('permissions/update-sort', ['as' => 'admin.permissions.update_sort', 'uses' => 'PermissionController@updateSort']);

    //PermissionGroup
    Route::resource('permissiongroups', 'PermissionGroupController', ['except' => ['show']]);
    Route::group(['prefix' => 'permissiongroups','as' => 'admin.permissiongroups.'], function () {
        Route::get('build-tree', ['as' => 'build_tree', 'uses' => 'PermissionGroupController@buildTree']);
        Route::post('update-sort', ['as' => 'update_sort', 'uses' => 'PermissionGroupController@updateSort']);
    });

    //Articles
    Route::resource('articles', 'ArticleController');

    //Settings
    Route::resource('settings', 'SettingController');
});

//Api
Route::group(['prefix' => 'api', 'middleware' => 'allowOrigin'], function () {
    //Users
    Route::resource('users', 'Api\UserController', ['only' => ['index', 'show']]);
});
