<?php

namespace ZfMetal\Agenda\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * CalendarControllerFactory
 *
 *
 *
 * @author
 * @license
 * @link
 */
class CalendarControllerFactory implements FactoryInterface
{

    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $container->get("doctrine.entitymanager.orm_default");
        /* @var $grid \ZfMetal\Datagrid\Grid */
        $grid = $container->build("zf-metal-datagrid", ["customKey" => "zfmetal-agenda-entity-calendar"]);
        return new \ZfMetal\Agenda\Controller\CalendarController($em,$grid);
    }


}

