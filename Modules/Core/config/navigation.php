<?php


return [
    [
        'key'   => 'dashboard',
        'label' => 'Dashboard',
        'route' => 'dashboard',
        'icon'  => 'home',
    ],
    [
        'key'   => 'settings',
        'label' => 'Settings',
        'icon'  => 'cog',
        'children' => [
            [
                'key'   => 'company-profile',
                'label' => 'Company Profile',
                'route' => 'core.settings.company',
                'permission' => 'core.manage_settings',
            ],
        ],
    ],
];
