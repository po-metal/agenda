<?php

namespace ZfMetal\Agenda\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CalendarRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class CalendarRepository extends EntityRepository
{

    public function save(\ZfMetal\Agenda\Entity\Calendar $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Agenda\Entity\Calendar $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

