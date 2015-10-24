<?php
return [
    'dashboard' => [
        'permission' => 'admin_user',
        'icon' => 'fa-dashboard',
        'edit' => true,
        'name' => 'messages.dashboard'
    ],
    'users' => [
        'permission' => 'admin_user',
        'icon' => 'fa-users',
        'edit' => true,
        'name' => 'messages.users'
    ],
    'roles' => [
        'permission' => 'admin_user',
        'icon' => 'fa-get-pocket',
        'edit' => true,
        'name' => 'messages.roles'
    ],
    'permissions' => [
        'permission' => 'admin_user',
        'icon' => 'fa-lock',
        'edit' => true,
        'name' => 'messages.permissions'
    ],
    'articles' => [
        'permission' => 'admin_user', //Add admin_article to Permissions table and assing a Role.
        'icon' => 'fa-file-o',
        'edit' => true,
        'name' => 'messages.articles'
    ],
    'settings' => [
        'permission' => 'admin_user', //Add admin_article to Permissions table and assing a Role.
        'icon' => 'fa-file-o',
        'edit' => true,
        'name' => 'messages.settings'
    ]        
];