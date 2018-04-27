<?php

namespace ZfMetal\Agenda\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ScheduleRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ScheduleRepository extends EntityRepository
{

    public function save(\ZfMetal\Agenda\Entity\Schedule $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Agenda\Entity\Schedule $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

