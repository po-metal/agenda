<?php

namespace ZfMetal\Agenda\Options;

/**
 * ModuleOptions
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ModuleOptions extends \Zend\Stdlib\AbstractOptions
{

    private $ticketEntity = '';

    public function getTicketEntity()
    {
        return $this->ticketEntity;
    }

    public function setTicketEntity($ticketEntity)
    {
        $this->ticketEntity= $ticketEntity;
    }


}

