<?php

return [
    'router' => [
        'routes' => [
            'ZfMetal\\Calendar' => [
                'type' => 'Literal',
                'mayTerminate' => false,
                'options' => [
                    'route' => '/metal/calendar',
                    'defaults' => [
                        'controller' => \ZfMetal\Calendar\Controller\CalendarController::CLASS,
                        'action' => 'grid',
                    ],
                ],
                'child_routes' => [
                    'Holiday' => [
                        'type' => 'Literal',
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/holiday',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\HolidayController::CLASS,
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
                                        'controller' => \ZfMetal\Calendar\Controller\HolidayController::CLASS,
                                        'action' => 'grid',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'Calendar' => [
                        'type' => 'Literal',
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/calendar',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\CalendarController::CLASS,
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
                                        'controller' => \ZfMetal\Calendar\Controller\CalendarController::CLASS,
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
                                'controller' => \ZfMetal\Calendar\Controller\ManagerCalendarController::CLASS,
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
                                        'controller' => \ZfMetal\Calendar\Controller\ManagerCalendarController::CLASS,
                                        'action' => 'list',
                                    ],
                                ],
                            ],
                            'Manage' => [
                                'type' => 'Segment',
                                'mayTerminate' => true,
                                'options' => [
                                    'route' => '/manage[/:id]',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\ManagerCalendarController::CLASS,
                                        'action' => 'manage',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'Day' => [
                        'type' => 'Literal',
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/day',
                            'defaults' => [
                                'controller' => 'ZfMetal\\Calendar\\Controller\\DayController',
                                'action' => 'g',
                            ],
                        ],
                        'child_routes' => [
                            'G' => [
                                'type' => 'Segment',
                                'mayTerminate' => true,
                                'options' => [
                                    'route' => '/g',
                                    'defaults' => [
                                        'controller' => 'ZfMetal\\Calendar\\Controller\\DayController',
                                        'action' => 'g',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'Ticket' => [
                        'type' => 'Literal',
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/ticket',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\TicketScheduleController::CLASS,
                                'action' => 'schedule',
                            ],
                        ],
                        'child_routes' => [
                            'Schedule' => [
                                'type' => 'Segment',
                                'mayTerminate' => true,
                                'options' => [
                                    'route' => '/schedule',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\TicketScheduleController::CLASS,
                                        'action' => 'schedule',
                                    ],
                                ],
                            ],
                            'Grid' => [
                                'type' => 'Segment',
                                'mayTerminate' => true,
                                'options' => [
                                    'route' => '/grid',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\TicketController::CLASS,
                                        'action' => 'grid',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'TicketSchedule' => [
                        'type' => 'Literal',
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/ticket-schedule',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\TicketScheduleController::CLASS,
                                'action' => 'schedule',
                            ],
                        ],
                        'child_routes' => [
                            'Schedule' => [
                                'type' => 'Segment',
                                'mayTerminate' => true,
                                'options' => [
                                    'route' => '/schedule',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\TicketScheduleController::CLASS,
                                        'action' => 'schedule',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'TicketState' => [
                        'type' => 'Literal',
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/ticket-state',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\TicketStateController::CLASS,
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
                                        'controller' => \ZfMetal\Calendar\Controller\TicketStateController::CLASS,
                                        'action' => 'grid',
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