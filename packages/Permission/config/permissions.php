<?php

use App\Enums\Permission;
use App\Enums\Role;

return [
    'permissions' => [
        ['name' => Permission::MANAGE_STAFF],
        ['name' => Permission::MANAGE_USER],
        ['name' => Permission::SEARCH_STAFF],
        ['name' => Permission::SEARCH_USER],

        ['name' => Permission::STAFF_MANAGE_USER],
        ['name' => Permission::STAFF_SEARCH_USER],

        ['name' => Permission::USER_READ_STAFF],
        ['name' => Permission::USER_READ_SELF],
        ['name' => Permission::USER_SEARCH_STAFF],
    ],

    'default_permission' => [
        'admin' => Permission::all(), // Admin có tất cả quyền
        'staff' => [
            Permission::STAFF_MANAGE_USER,
            Permission::STAFF_SEARCH_USER,
        ],
        'user' => [
            Permission::USER_READ_STAFF,
            Permission::USER_READ_SELF,
            Permission::USER_SEARCH_STAFF,
        ],
    ],

];
