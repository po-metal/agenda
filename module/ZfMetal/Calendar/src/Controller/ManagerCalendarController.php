<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use ZfMetal\Calendar\Entity\Calendar;
use ZfMetal\Calendar\Form\CalendarForm;

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

        $calendar = $this->buildCalendar();

        $form = new CalendarForm();

        //@ToReview
        $form->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEm()));
        $form->bind($calendar);



        return ["form" => $form];
    }

    protected function buildCalendar(){
        $id = $this->params("id");
        if($id){
            $calendar = $this->getCalendarRepository()->find($id);
            if(!$calendar){
                throw new \Exception("Calendar doesn´t exist");
            }
        }else{
            $calendar = new Calendar();
        }
        return $calendar;
    }


}

