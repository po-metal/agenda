<?php

return array(
    'controller_plugins' => array(
        'factories' => array(
            \ZfMetal\Agenda\Controller\Plugin\Options::class => \ZfMetal\Agenda\Factory\Controller\Plugin\OptionsFactory::class,
        ),
        'aliases' => array(
            'zfMetal\\AgendaOptions' => \ZfMetal\Agenda\Controller\Plugin\Options::class,
        ),
    ),
);