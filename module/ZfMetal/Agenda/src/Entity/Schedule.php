<?php

namespace ZfMetal\Agenda\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Schedule
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="zfma_schedule")
 * @ORM\Entity(repositoryClass="ZfMetal\Agenda\Repository\ScheduleRepository")
 */
class Schedule
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
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"calendar","empty_option": "",
     * "target_class":"\ZfMetal\Agenda\Entity\Calendar", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Agenda\Entity\Calendar")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id", nullable=true)
     */
    public $calendar = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"day", "description":"", "addon":""})
     * @ORM\Column(type="integer", length=1, unique=false, nullable=false, name="day")
     */
    public $day = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"start", "description":"", "addon":""})
     * @ORM\Column(type="time", unique=false, nullable=false, name="start")
     */
    public $start = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"end", "description":"", "addon":""})
     * @ORM\Column(type="time", unique=false, nullable=false, name="end")
     */
    public $end = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"startBreak", "description":"", "addon":""})
     * @ORM\Column(type="time", unique=false, nullable=true, name="start_break")
     */
    public $startBreak = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"endBreak", "description":"", "addon":""})
     * @ORM\Column(type="time", unique=false, nullable=true, name="end_break")
     */
    public $endBreak = null;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCalendar()
    {
        return $this->calendar;
    }

    public function setCalendar($calendar)
    {
        $this->calendar = $calendar;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function setDay($day)
    {
        $this->day = $day;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function setEnd($end)
    {
        $this->end = $end;
    }

    public function getStartBreak()
    {
        return $this->startBreak;
    }

    public function setStartBreak($startBreak)
    {
        $this->startBreak = $startBreak;
    }

    public function getEndBreak()
    {
        return $this->endBreak;
    }

    public function setEndBreak($endBreak)
    {
        $this->endBreak = $endBreak;
    }

    public function __toString()
    {
        return (string) $this->day;
    }


}

