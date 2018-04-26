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
                ],
            ],
        ],
    ],
];