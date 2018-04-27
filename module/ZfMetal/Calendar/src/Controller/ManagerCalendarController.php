<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use ZfMetal\Calendar\Entity\Calendar;
use ZfMetal\Calendar\Entity\Schedule;
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

    /**
     * @var CalendarForm
     */
    public $calendarForm = null;

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

    public function __construct(\Doctrine\ORM\EntityManager $em, CalendarForm $form)
    {
        $this->em = $em;
        $this->calendarForm = $form;
    }

    public function listAction()
    {
        $calendars = $this->getCalendarRepository()->findAll();

        return ["calendars" => $calendars];
    }

    public function manageAction()
    {

        $calendar = $this->buildCalendar();

//        $form = new CalendarForm($this->getEm());

        //@ToReview
        //$form->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEm()));


        //Annotation way
//        $form = $this->formBuilder($this->getEm(),Calendar::class,true,true);
//        $form->bind($calendar);

        $this->calendarForm->init();
       // $this->calendarForm->setObject($calendar);
        $this->calendarForm->bind($calendar);
      //  $this->calendarForm->get('schedules')->setObject($calendar->getSchedules());

        if ($this->getRequest()->isPost()) {
            $postData = $this->getRequest()->getPost();

            echo "<pre>";
            // var_dump($postData);
            echo "</pre>";
            $this->calendarForm->setData($postData);

            if ($this->calendarForm->isValid()) {

                $this->getEm()->persist($calendar);
                $this->getEm()->flush();
            }
        }


        return ["form" => $this->calendarForm];
    }

    protected function buildCalendar()
    {
        $id = $this->params("id");
        if ($id) {
            $calendar = $this->getCalendarRepository()->find($id);
            if (!$calendar) {
                throw new \Exception("Calendar doesn´t exist");
            }


        } else {
            $calendar = new Calendar();
            $calendar->setName("ASD");
            $calendar->addSchedule($this->buildSchedule($calendar,1));
            $calendar->addSchedule($this->buildSchedule($calendar,2));
            $calendar->addSchedule($this->buildSchedule($calendar,3));
            $calendar->addSchedule($this->buildSchedule($calendar,4));
            $calendar->addSchedule($this->buildSchedule($calendar,5));
            $calendar->addSchedule($this->buildSchedule($calendar,6));
            $calendar->addSchedule($this->buildSchedule($calendar,7));
            $calendar->addSchedule($this->buildSchedule($calendar,8));

        }
        $this->getEm()->persist($calendar);
        $this->getEm()->flush();
        return $calendar;
    }

    protected function buildSchedule($calendar, $day )
    {
        $schedule = new Schedule();
        $schedule->setCalendar($calendar);
        $schedule->setDay($day);
        $schedule->setStart(new \DateTime("11:00"));
        $schedule->setEnd(new \DateTime("18:00"));
        return $schedule;
    }



}

