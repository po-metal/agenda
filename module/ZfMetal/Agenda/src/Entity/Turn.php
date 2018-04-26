<?php

namespace ZfMetal\Agenda\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Turn
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="zfma_")
 * @ORM\Entity(repositoryClass="ZfMetal\Agenda\Repository\TurnRepository")
 */
class Turn
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
     * @Annotation\Options({"label":"interval", "description":"", "addon":""})
     * @ORM\Column(type="integer", length=6, unique=false, nullable=true,
     * name="interval")
     */
    public $interval = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"break", "description":"", "addon":""})
     * @ORM\Column(type="integer", length=6, unique=false, nullable=true, name="break")
     */
    public $break = null;

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

    public function getInterval()
    {
        return $this->interval;
    }

    public function setInterval($interval)
    {
        $this->interval = $interval;
    }

    public function getBreak()
    {
        return $this->break;
    }

    public function setBreak($break)
    {
        $this->break = $break;
    }

    public function __toString()
    {
        return (string);
    }


}

