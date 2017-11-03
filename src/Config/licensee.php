<?php

return [
    'name' => 'roleMaker',
    'pageTitle' => 'Role Maker',
    'auth_gaurd' => 'admin',
    'middleware' => ['web'],
    'user_table' => 'admin',
    'utility_prefix' => 'licensee',
    'manual_permission' => [
        'systemutilities_view' => ['view', 'edit', 'delete']
    ]
];
