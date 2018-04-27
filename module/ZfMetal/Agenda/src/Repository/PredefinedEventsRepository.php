<?php

namespace ZfMetal\Agenda\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PredefinedEventsRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class PredefinedEventsRepository extends EntityRepository
{

    public function save(\ZfMetal\Agenda\Entity\PredefinedEvents $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Agenda\Entity\PredefinedEvents $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

