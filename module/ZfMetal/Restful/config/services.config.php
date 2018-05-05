<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'ZfMetalRestful.options' => \ZfMetal\Restful\Factory\Options\ModuleOptionsFactory::class,
        ),
    ),
);