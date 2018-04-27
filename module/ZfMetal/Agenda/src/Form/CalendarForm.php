<?php

namespace ZfMetal\Agenda\Form;

use Zend\Form\Form;

class CalendarForm extends \Zend\Form\Form
{


    public function __construct()
    {
        parent::__construct('calendar');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");
        $this->setAttribute('autocomplete', "off");

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Name',
                'class' => 'form-control ',
                'required' => 'required',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => 'Nombre',
            )
        ));

        //Monday
        $this->addSchedule(1);
        //Tuesday
        $this->addSchedule(2);
        //Wednesday
        $this->addSchedule(3);
        //thursday
        $this->addSchedule(4);
        //friday
        $this->addSchedule(5);
        //saturday
        $this->addSchedule(6);
        //sunday
        $this->addSchedule(7);
        //holiday
        $this->addSchedule(8);

    }

    public function addSchedule($day){
        $this->add(new ScheduleForm($day));
    }

}
