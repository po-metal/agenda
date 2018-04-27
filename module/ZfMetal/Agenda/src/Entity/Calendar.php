<?php

namespace ZfMetal\Agenda\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
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
 * @ORM\Table(name="zfma_calendar")
 * @ORM\Entity(repositoryClass="ZfMetal\Agenda\Repository\CalendarRepository")
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
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectMultiCheckbox")
     * @Annotation\Options({"label":"schedules","target_class":"\ZfMetal\Agenda\Entity\Schedule",
     * "description":""})
     * @ORM\OneToMany(targetEntity="\ZfMetal\Agenda\Entity\Schedule",
     * mappedBy="calendar")
     */
    public $schedules = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectMultiCheckbox")
     * @Annotation\Options({"label":"specificSchedules","target_class":"\ZfMetal\Agenda\Entity\SpecificSchedule",
     * "description":""})
     * @ORM\OneToMany(targetEntity="\ZfMetal\Agenda\Entity\SpecificSchedule",
     * mappedBy="calendar")
     */
    public $specificSchedules = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectMultiCheckbox")
     * @Annotation\Options({"label":"events","target_class":"\ZfMetal\Agenda\Entity\Event",
     * "description":""})
     * @ORM\OneToMany(targetEntity="\ZfMetal\Agenda\Entity\Event", mappedBy="calendar")
     */
    public $events = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"predefinedEvents","empty_option": "",
     * "target_class":"\ZfMetal\Agenda\Entity\PredefinedEvents", "description":""})
     * @ORM\OneToOne(targetEntity="\ZfMetal\Agenda\Entity\PredefinedEvents")
     * @ORM\JoinColumn(name="predefined_events_id", referencedColumnName="id",
     * nullable=true)
     */
    public $predefinedEvents = null;

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


}

