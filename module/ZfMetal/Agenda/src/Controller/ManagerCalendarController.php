<?php

namespace ZfMetal\Agenda\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use ZfMetal\Agenda\Entity\Calendar;

/**
 * ManagerCalendarController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ManagerCalendarController extends AbstractActionController
{

    const ENTITY = Calendar::class;

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

        return ["calendars"=> $calendars];
    }

    public function manageAction()
    {
        return [];
    }


}

