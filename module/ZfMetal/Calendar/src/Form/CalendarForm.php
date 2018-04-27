<?php

namespace ZfMetal\Calendar\Form;

use Zend\Form\Element\Collection;
use Zend\Form\Form;

class CalendarForm extends \Zend\Form\Form implements \Zend\Stdlib\InitializableInterface
{


    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;

    public function getEm()
    {
        return $this->em;
    }


    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
        parent::__construct('calendar');
        $this->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEm()));
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");
        $this->setAttribute('autocomplete', "off");
    }

    public  function init(){

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


//        $schedules = new \Zend\Form\Element\Collection();
//        $schedules->setAllowAdd(true)
//            ->setAllowRemove(true)
//            ->setCount(3)
//            ->setShouldCreateTemplate(true)
//            ->setTargetElement(new ScheduleForm($this->getEm()))
//            ->setLabel('Configurar Schedule')
//            ->setName('schedules');
//        $this->add($schedules);

        $this->add([
            'type' => Collection::class,
            'name' => 'schedules',
            'options' => [
                'label' => 'Configurar Schedule',
              //  'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => [
                    'type' => ScheduleForm::class,
                ],
            ],
        ]);


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
