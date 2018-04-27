<?php

namespace ZfMetal\Calendar\Form;

use Zend\Form\Element\Collection;
use Zend\Form\Form;

class CalendarForm extends \Zend\Form\Form
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;

    public function getEm()
    {
        return $this->em;
    }

    public function __construct($em)
    {
        parent::__construct('calendar');
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


        $schedules = new \Zend\Form\Element\Collection();
        $schedules->setAllowAdd(true)
            ->setAllowRemove(true)
            ->setCount(1)
            ->setShouldCreateTemplate(true)
            ->setTargetElement(new ScheduleForm($em))
            ->setLabel('Configurar Schedule')
            ->setName('schedules');
        $this->add($schedules);

//        $this->add([
//            'type' => Collection::class,
//            'name' => 'schedules',
//            'options' => [
//                'label' => 'Configurar Schedule',
//                'count' => 1,
//                'should_create_template' => true,
//                'allow_add' => true,
//                'target_element' => [
//                    'type' => new ScheduleForm($em),
//                ],
//            ],
//        ]);


        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => "Guardar",
                'class' => 'btn btn-primary',
            ),
            'options' => array(
                'label' => 'Guardar',
            )
        ));

    }


}
