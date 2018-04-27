<?php

namespace ZfMetal\Calendar\Form;

use Zend\Form\Element\Collection;
use Doctrine\Common\Persistence\ObjectManager;

class CalendarForm extends \Zend\Form\Form implements \DoctrineModule\Persistence\ObjectManagerAwareInterface
{


    /**
     * @var ObjectManager
     */
    public $objectManager = null;

    /**
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * @param ObjectManager $objectManager
     */
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }


    public function __construct()
    {
        parent::__construct('calendar');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");
        $this->setAttribute('autocomplete', "off");
    }

    public function init()
    {

        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getObjectManager(),false);
        //$hydrator->addStrategy();
        $this->setHydrator($hydrator);

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
//           // ->setCount(1)
//            ->setShouldCreateTemplate(true)
//            ->setTargetElement(new ScheduleForm())
//            ->setLabel('Configurar Schedule')
//            ->setName('schedules');
//
//        $this->add($schedules);

        $this->add([
            'type' => Collection::class,
            'name' => 'schedules',
            'options' => [
                'label' => 'Configurar Schedule',
                'count' => 1,
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
