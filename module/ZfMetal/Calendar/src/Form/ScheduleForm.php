<?php

namespace ZfMetal\Calendar\Form;

use Doctrine\Common\Persistence\ObjectManager;


class ScheduleForm extends \Zend\Form\Fieldset
{


    public function __construct(ObjectManager $em)
    {
        parent::__construct("schedule");
        $this->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em));
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");
        $this->setAttribute('autocomplete', "off");

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            )
        ));

        $this->add(array(
            'name' => 'day',
            'attributes' => array(
                'type' => 'hidden'
            )
        ));

        $this->add(array(
            'name' => 'start',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control ',
                'required' => 'required',
                'autocomplete' => "off",
                'value' => "00:00"
            ),
            'options' => array(
                'label' => 'Inicio',
            )
        ));

        $this->add(array(
            'name' => 'end',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control ',
                'required' => 'required',
                'autocomplete' => "off",
                'value' => "00:00"
            ),
            'options' => array(
                'label' => 'Fin',
            )
        ));


        $this->add(array(
            'name' => 'startBreak',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control ',
                'autocomplete' => "off",
                'value' => "00:00"
            ),
            'options' => array(
                'label' => 'Inicio Break',
            )
        ));

        $this->add(array(
            'name' => 'endBreak',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control ',
                'autocomplete' => "off",
                'value' => "00:00"
            ),
            'options' => array(
                'label' => 'Fin Break',
            )
        ));

    }

}