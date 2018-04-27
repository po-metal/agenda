<?php

return [
    'navigation' => [
        'default' => [
            [
                'label' => 'Calendar',
                'detail' => '',
                'icon' => '',
                'route' => 'ZfMetal\\Calendar/ManagerCalendar/List',
            ],
            [
                'label' => 'Feriados',
                'detail' => '',
                'icon' => '',
                'permission' => 'general-admin',
                'route' => 'ZfMetal\\Calendar/Holiday/Grid',
            ],
        ],
    ],
];