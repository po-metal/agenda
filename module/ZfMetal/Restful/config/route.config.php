<?php

return [
    'router' => [
        'routes' => [
            'zfmapi' => [
                'type' => 'Literal',
                'mayTerminate' => false,
                'options' => [
                    'route' => '/zfmr/api',
                ],
                'child_routes' => [
                    'list' => [
                        'type' => 'Segment',
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/:entityAlias[/:id]',
                            'defaults' => [
                                'controller' => \ZfMetal\Restful\Controller\MainController::CLASS,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];