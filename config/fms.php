<?php

return [
    'gst' => 10,
    'defaultSite' => 3,
    'paginationLimit' => 50,
    'roles' => [
        'super_admin' => [
            'name' => 'super_admin',
            'display_name' => 'Super Admin',
            'description' => 'Super Admin User',
        ],
        'admin' => [
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'Admin User',
        ],
        'general' => [
            'name' => 'general',
            'display_name' => 'General',
            'description' => 'General User',
        ],
    ],
    'shareBooking' => [
        'first' => 3,
        'second' => 4
    ],   
    'import' => [
        'default_site' => 3
    ]
];
