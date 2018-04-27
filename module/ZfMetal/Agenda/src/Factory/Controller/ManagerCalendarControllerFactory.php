<?php

namespace ZfMetal\Agenda\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * ManagerCalendarControllerFactory
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ManagerCalendarControllerFactory implements FactoryInterface
{

    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $container->get("doctrine.entitymanager.orm_default");
        return new \ZfMetal\Agenda\Controller\ManagerCalendarController($em);
    }


}

