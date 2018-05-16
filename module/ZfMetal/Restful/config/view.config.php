<?php

return [
    'view_manager' => [
        'display_exceptions' => false,
        'display_not_found_reason' => false,
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ],
];
