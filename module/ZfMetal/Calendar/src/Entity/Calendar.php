<?php

namespace ZfMetal\Calendar\Entity;

use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Calendar
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_calendar")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\CalendarRepository")
 */
class Calendar
{

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"ID", "description":"", "addon":""})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", length=11, unique=false, nullable=false, name="id")
     */
    public $id = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"name", "description":"", "addon":""})
     * @ORM\Column(type="string", length=50, unique=true, nullable=false, name="name")
     */
    public $name = null;

    /**
     * @Annotation\ComposedObject({"name":"schedules", "target_object":"\ZfMetal\Calendar\Entity\Schedule", "is_collection":"true", "options":{"count":1, "should_create_template":"true", "allow_add":"true", "allow_remove":"true"}})
     * @ORM\OneToMany(targetEntity="\ZfMetal\Calendar\Entity\Schedule",
     * mappedBy="calendar", cascade={"persist", "remove"}, fetch="EAGER")
     */
    public $schedules = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectMultiCheckbox")
     * @Annotation\Options({"label":"specificSchedules","target_class":"\ZfMetal\Calendar\Entity\SpecificSchedule",
     * "description":""})
     * @ORM\OneToMany(targetEntity="\ZfMetal\Calendar\Entity\SpecificSchedule",
     * mappedBy="calendar")
     */
    public $specificSchedules = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectMultiCheckbox")
     * @Annotation\Options({"label":"events","target_class":"\ZfMetal\Calendar\Entity\Event",
     * "description":""})
     * @ORM\OneToMany(targetEntity="\ZfMetal\Calendar\Entity\Event", mappedBy="calendar")
     */
    public $events = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"predefinedEvents","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\PredefinedEvents", "description":""})
     * @ORM\OneToOne(targetEntity="\ZfMetal\Calendar\Entity\PredefinedEvents")
     * @ORM\JoinColumn(name="predefined_events_id", referencedColumnName="id",
     * nullable=true)
     */
    public $predefinedEvents = null;

    /**
     * Calendar constructor.
     * @param null $id
     */
    public function __construct()
    {
        $this->schedules = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSchedules()
    {
        return $this->schedules;
    }

    public function setSchedules($schedules)
    {
        $this->schedules = $schedules;
    }

    public function getSpecificSchedules()
    {
        return $this->specificSchedules;
    }

    public function setSpecificSchedules($specificSchedules)
    {
        $this->specificSchedules = $specificSchedules;
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function setEvents($events)
    {
        $this->events = $events;
    }

    public function getPredefinedEvents()
    {
        return $this->predefinedEvents;
    }

    public function setPredefinedEvents($predefinedEvents)
    {
        $this->predefinedEvents = $predefinedEvents;
    }

    public function __toString()
    {
        return (string) $this->name;
    }




    public function addSchedules(\Doctrine\Common\Collections\ArrayCollection $schedules) {
        foreach ($schedules as $schedule) {
            $this->addSchedule($schedule);
        }
    }

    public function removeSchedules(\Doctrine\Common\Collections\ArrayCollection $schedules) {
        foreach ($schedules as $schedule) {
            $this->removeSchedule($schedule);
        }
    }

    public function addSchedule(\ZfMetal\Calendar\Entity\Schedule $schedule) {
        if ($this->schedules->contains($schedule)) {
            return;
        }
        $this->schedules[] = $schedule;
    }

    public function removeSchedule(\ZfMetal\Calendar\Entity\Schedule $schedule) {
        if (!$this->schedules->contains($schedule)) {
            return;
        }
        $this->schedules->removeElement($schedule);
    }

}

