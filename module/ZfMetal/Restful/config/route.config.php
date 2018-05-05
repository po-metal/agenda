<?php

return [
    'router' => [
        'routes' => [
            'zfmapi' => [
                'type' => 'Literal',
                'mayTerminate' => false,
                'options' => [
                    'route' => '/zfmapi',
                    'defaults' => [
                        'controller' => \ZfMetal\Restful\Controller\MainController::CLASS,
                        'action' => 'list',
                    ],
                ],
                'child_routes' => [
                    'list' => [
                        'type' => 'Segment',
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/list/:entityAlias',
                            'defaults' => [
                                'controller' => \ZfMetal\Restful\Controller\MainController::CLASS,
                                'action' => 'list',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];