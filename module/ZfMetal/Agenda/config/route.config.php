<?php

return [
    'router' => [
        'routes' => [
            'ZfMetal\\Agenda' => [
                'type' => 'Literal',
                'mayTerminate' => false,
                'options' => [
                    'route' => '/zf-metal\\agenda',
                    'defaults' => [
                        'controller' => \ZfMetal\Agenda\Controller\CalendarController::CLASS,
                        'action' => 'grid',
                    ],
                ],
                'child_routes' => [
                    'Calendar' => [
                        'type' => 'Literal',
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/calendar',
                            'defaults' => [
                                'controller' => \ZfMetal\Agenda\Controller\CalendarController::CLASS,
                                'action' => 'grid',
                            ],
                        ],
                        'child_routes' => [
                            'Grid' => [
                                'type' => 'Segment',
                                'mayTerminate' => true,
                                'options' => [
                                    'route' => '/grid',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Agenda\Controller\CalendarController::CLASS,
                                        'action' => 'grid',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'ManagerCalendar' => [
                        'type' => 'Literal',
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/manager-calendar',
                            'defaults' => [
                                'controller' => \ZfMetal\Agenda\Controller\ManagerCalendarController::CLASS,
                                'action' => 'list',
                            ],
                        ],
                        'child_routes' => [
                            'List' => [
                                'type' => 'Segment',
                                'mayTerminate' => true,
                                'options' => [
                                    'route' => '/list',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Agenda\Controller\ManagerCalendarController::CLASS,
                                        'action' => 'list',
                                    ],
                                ],
                            ],
                            'Manage' => [
                                'type' => 'Segment',
                                'mayTerminate' => true,
                                'options' => [
                                    'route' => '/manage',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Agenda\Controller\ManagerCalendarController::CLASS,
                                        'action' => 'manage',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];