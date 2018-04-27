<?php

return [
    'form_elements' => [
        'factories' => [
            \ZfMetal\Calendar\Form\ScheduleForm::class => \ZfMetal\Calendar\Factory\Form\ScheduleFormFactory::class,
            \ZfMetal\Calendar\Form\CalendarForm::class => \ZfMetal\Calendar\Factory\Form\CalendarFormFactory::class,
        ],
    ],
    'form' => [
        'factories' => [
            \ZfMetal\Calendar\Form\ScheduleForm::class => \ZfMetal\Calendar\Factory\Form\ScheduleFormFactory::class,
            \ZfMetal\Calendar\Form\CalendarForm::class => \ZfMetal\Calendar\Factory\Form\CalendarFormFactory::class,
        ],
    ],
];