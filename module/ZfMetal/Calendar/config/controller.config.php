<?php

return array(
    'controllers' => array(
        'factories' => array(
            \ZfMetal\Calendar\Controller\CalendarController::class => \ZfMetal\Calendar\Factory\Controller\CalendarControllerFactory::class,
            \ZfMetal\Calendar\Controller\ManagerCalendarController::class => \ZfMetal\Calendar\Factory\Controller\ManagerCalendarControllerFactory::class,
            \ZfMetal\Calendar\Controller\HolidayController::class => \ZfMetal\Calendar\Factory\Controller\HolidayControllerFactory::class,
        ),
    ),
);