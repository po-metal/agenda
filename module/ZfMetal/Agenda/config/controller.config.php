<?php

return array(
    'controllers' => array(
        'factories' => array(
            \ZfMetal\Agenda\Controller\CalendarController::class => \ZfMetal\Agenda\Factory\Controller\CalendarControllerFactory::class,
            \ZfMetal\Agenda\Controller\ManagerCalendarController::class => \ZfMetal\Agenda\Factory\Controller\ManagerCalendarControllerFactory::class,
        ),
    ),
);