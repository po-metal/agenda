<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'ZfMetal\\Agenda.options' => \ZfMetal\Agenda\Factory\Options\ModuleOptionsFactory::class,
        ),
    ),
);