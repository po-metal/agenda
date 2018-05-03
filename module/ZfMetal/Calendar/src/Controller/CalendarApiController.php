<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZfMetal\Calendar\Entity\Calendar;

/**
 * CalendarApiController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class CalendarApiController extends AbstractActionController
{

    const ENTITY = '\\ZfMetal\\Calendar\\Entity\\Calendar';

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;

    public function getEm()
    {
        return $this->em;
    }

    public function setEm(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEntityRepository()
    {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    public function getCalendarRepository()
    {
        return $this->getEm()->getRepository(Calendar::class);
    }

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function listAction()
    {
        $calendars = $this->getCalendarRepository()->findAll();
        $o = array();
        foreach ($calendars as $calendar){
            $o[] = ["id" => $calendar->getId(), "name" => $calendar->getName()];
        }

        return new JsonModel($o);
    }


}

