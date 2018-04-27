<?php

namespace ZfMetal\Calendar\Factory\Form;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\Calendar\Form\CalendarForm;

class CalendarFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $name, array $options = null)
    {
        $em = $container->get("doctrine.entitymanager.orm_default");
        return new CalendarForm($em);
    }

}
